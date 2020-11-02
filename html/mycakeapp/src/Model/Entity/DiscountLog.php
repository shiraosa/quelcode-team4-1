<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiscountLog Entity
 *
 * @property int $id
 * @property int $discount_type_id
 * @property int $reservation_id
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\DiscountType $discount_type
 * @property \App\Model\Entity\Reservation $reservation
 */
class DiscountLog extends Entity
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
        'discount_type_id' => true,
        'reservation_id' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'discount_type' => true,
        'reservation' => true,
    ];
}
