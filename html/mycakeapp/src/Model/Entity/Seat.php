<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Seat Entity
 *
 * @property int $id
 * @property int $schedule_id
 * @property string $seat_number
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Schedule $schedule
 * @property \App\Model\Entity\Reservation[] $reservations
 */
class Seat extends Entity
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
        'schedule_id' => true,
        'seat_number' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'schedule' => true,
        'reservations' => true,
    ];
}
