<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;

/**
 * Users Model
 *
 * @property \App\Model\Table\CreditcardsTable&\Cake\ORM\Association\HasMany $Creditcards
 * @property \App\Model\Table\ReservationsTable&\Cake\ORM\Association\HasMany $Reservations
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Creditcards', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Reservations', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Points', [
            'foreignKey' => 'user_id',
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
            ->scalar('mailaddress')
            ->maxLength('mailaddress', 100)
            ->requirePresence('mailaddress', 'create')
            ->notEmptyString('mailaddress', '空白になっています')
            ->add('mailaddress', 'custom', [
                'rule' => 'email',
                'message' => 'メールアドレスが間違っているようです'
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', '空白になっています')
            ->add('password', [
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'last' => true,
                    'message' => 'パスワードに使えない文字が入力されています',
                ],
                'ascii' => [
                    'rule' => 'ascii',
                    'message' => 'パスワードに使えない文字が入力されています',
                ]
            ])
            ->lengthBetween('password', [4, 13], 'パスワードは4文字以上、13文字以下にしてください');

        $validator
            ->scalar('passwordConfirming')
            ->requirePresence('passwordConfirming', 'create')
            ->notEmptyString('passwordConfirming', '空白になっています')
            ->add('passwordConfirming', [
                'compareWith' => [
                    'rule' => ['compareWith', 'password'],
                    'last' => true,
                    'message' => 'パスワードが一致していません',
                ],
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'message' => 'パスワードに使えない文字が入力されています',
                ],
                'ascii' => [
                    'rule' => 'ascii',
                    'message' => 'パスワードに使えない文字が入力されています',
                ]
            ])
            ->lengthBetween('passwordConfirming', [4, 13], 'パスワードは4文字以上、13文字以下にしてください');

        $validator
            ->boolean('is_temporary')
            ->notEmptyString('is_temporary');

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(
            ['mailaddress', 'is_deleted'],
            'このメールアドレスは既に使用されています'
        ));

        return $rules;
    }

    //削除されたユーザーはログイン不可
    public function findAuth(Query $query)
    {
        $query->where([
            'Users.is_deleted' => 0
        ]);
        return $query;
    }
}
