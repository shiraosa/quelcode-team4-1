<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiscountTypes Model
 *
 * @property \App\Model\Table\DiscountLogsTable&\Cake\ORM\Association\HasMany $DiscountLogs
 *
 * @method \App\Model\Entity\DiscountType get($primaryKey, $options = [])
 * @method \App\Model\Entity\DiscountType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DiscountType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DiscountType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DiscountType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DiscountType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DiscountType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DiscountType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiscountTypesTable extends Table
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

        $this->setTable('discount_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('DiscountLogs', [
            'foreignKey' => 'discount_type_id',
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
            ->scalar('discount_type')
            ->maxLength('discount_type', 50)
            ->requirePresence('discount_type', 'create')
            ->notEmptyString('discount_type');

        $validator
            ->scalar('discount_details')
            ->maxLength('discount_details', 300)
            ->requirePresence('discount_details', 'create')
            ->notEmptyString('discount_details');

        $validator
            ->integer('discount_price')
            ->requirePresence('discount_price', 'create')
            ->notEmptyString('discount_price');

        $validator
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDate('start_date');

        $validator
            ->scalar('banner_path')
            ->maxLength('banner_path', 100)
            ->allowEmptyString('banner_path');

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        return $validator;
    }
}
