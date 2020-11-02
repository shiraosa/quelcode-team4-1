<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BasicRate Entity
 *
 * @property int $id
 * @property string $ticket_type
 * @property int $basic_rate
 * @property \Cake\I18n\Date $start_date
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Reservation[] $reservations
 */
class BasicRate extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'ticket_type' => true,
        'basic_rate' => true,
        'start_date' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'reservations' => true,
    ];
}
