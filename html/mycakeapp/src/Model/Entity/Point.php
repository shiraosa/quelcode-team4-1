<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Point Entity
 *
 * @property int $id
 * @property int $payment_id
 * @property int $user_id
 * @property int $get_point
 * @property int $use_point
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Payment $payment
 * @property \App\Model\Entity\User $user
 */
class Point extends Entity
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
        'payment_id' => true,
        'user_id' => true,
        'get_point' => true,
        'use_point' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'payment' => true,
        'user' => true,
    ];
}
