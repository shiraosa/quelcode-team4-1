<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Seats Model
 *
 * @property \App\Model\Table\SchedulesTable&\Cake\ORM\Association\BelongsTo $Schedules
 * @property \App\Model\Table\ReservationsTable&\Cake\ORM\Association\HasMany $Reservations
 *
 * @method \App\Model\Entity\Seat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Seat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Seat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Seat|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Seat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Seat findOrCreate($search, callable $callback = null, $options = [])
 */
class SeatsTable extends Table
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

        $this->setTable('seats');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Schedules', [
            'foreignKey' => 'schedule_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Reservations', [
            'foreignKey' => 'seat_id',
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
            ->scalar('seat_number')
            ->maxLength('seat_number', 5)
            ->requirePresence('seat_number', 'create')
            ->notEmptyString('seat_number');

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['schedule_id'], 'Schedules'));

        return $rules;
    }
}
