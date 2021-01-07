<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reservation Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $seat_id
 * @property int $schedule_id
 * @property int $movie_id
 * @property int $payment_id
 * @property int $basic_rate_id
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Seat $seat
 * @property \App\Model\Entity\Schedule $schedule
 * @property \App\Model\Entity\Movie $movie
 * @property \App\Model\Entity\Payment $payment
 * @property \App\Model\Entity\BasicRate $basic_rate
 * @property \App\Model\Entity\DiscountLog[] $discount_logs
 */
class Reservation extends Entity
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
        'user_id' => true,
        'seat_id' => true,
        'schedule_id' => true,
        'movie_id' => true,
        'payment_id' => true,
        'basic_rate_id' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'seat' => true,
        'schedule' => true,
        'movie' => true,
        'payment' => true,
        'basic_rate' => true,
        'discount_logs' => true,
    ];
}
