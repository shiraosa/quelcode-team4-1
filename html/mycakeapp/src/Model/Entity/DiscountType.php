<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiscountType Entity
 *
 * @property int $id
 * @property string $discount_type
 * @property string $discount_details
 * @property int $discount_price
 * @property \Cake\I18n\Date $start_date
 * @property string|null $banner_path
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\DiscountLog[] $discount_logs
 */
class DiscountType extends Entity
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
        'discount_type' => true,
        'discount_details' => true,
        'discount_price' => true,
        'start_date' => true,
        'banner_path' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'discount_logs' => true,
    ];
}
