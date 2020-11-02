<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $creditcard_id
 * @property int $tax_id
 * @property int $total_payment
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Creditcard $creditcard
 * @property \App\Model\Entity\Tax $tax
 * @property \App\Model\Entity\Reservation[] $reservations
 */
class Payment extends Entity
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
        'creditcard_id' => true,
        'tax_id' => true,
        'total_payment' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'creditcard' => true,
        'tax' => true,
        'reservations' => true,
    ];
}
