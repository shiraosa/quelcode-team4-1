<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Creditcards Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Creditcard get($primaryKey, $options = [])
 * @method \App\Model\Entity\Creditcard newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Creditcard[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Creditcard|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Creditcard saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Creditcard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Creditcard[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Creditcard findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CreditcardsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('creditcards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'creditcard_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('owner_name')
            ->maxLength('owner_name', 100)
            ->requirePresence('owner_name', 'create')
            ->notEmptyString('owner_name', 'クレジットカード名義が入力されていません。')
            ->add('owner_name', 'custom', [
                'rule' => function ($value) {
                    // 名義（大文字半角アルファベット 姓名の間にスペース
                    return (1 === preg_match('/^[A-Z]+\s[A-Z]+\z/', $value));
                },
                'message' => '不正なクレジットカード名義です。'
            ]);

        $validator
            ->scalar('creditcard_number')
            ->maxLength('creditcard_number', 100)
            ->requirePresence('creditcard_number', 'create')
            ->notEmptyString('creditcard_number', 'クレジットカード番号を入力してください。')
            ->add('creditcard_number', 'creditCard', [
                'rule' => ['creditCard', 'all'],
                'message' => '不正なクレジットカード番号です。',
            ]);

        $validator
            ->date('expiration_date')
            ->requirePresence('expiration_date', 'create')
            ->notEmptyDate('expiration_date', '有効期限が入力されていません。')
            ->add('expiration_date', [
                'date' => [
                    'rule' => ['date', 'my'],
                    'message' => 'mm/yyで入力してください',
                ],
                'custom' => [
                    'rule' => function ($value) {
                        $thisMonth = Time::now()->year . '/' . Time::now()->month;
                        $cardDate = '20' . substr($value, -2) . '/' . substr($value, 0, 2);
                        return ($cardDate >= $thisMonth);
                    },
                    'message' => '未来の有効期限を入力してください'
                ]
            ]);

        $validator
            ->integer('code', '半角数字で入力してください')
            ->notEmptyString('code', 'セキュリティコードが入力されていません。')
            ->add('code', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 3, 4],
                    'message' => '不正なセキュリティコードです。',
                ]
            ]);

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        return $validator;
    }

    // 入力されたクレジットカードの有効期限が今月以降の未来であれば1を返す
    // public function is_futureDate($expiration_date)
    // {
    //     $cardDate = '20' . substr($expiration_date, -2) . '/' . substr($expiration_date, 0, 2) . '/01';
    //     $nowDate = Time::now()->year . '-' . Time::now()->month . '-1';
    //     if ($cardDate >= $nowDate) {
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }


    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
