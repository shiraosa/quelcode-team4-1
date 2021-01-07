<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movie Entity
 *
 * @property int $id
 * @property string $title
 * @property string $slideshow_img_path
 * @property string $screening_img_path
 * @property string $thumbnail_path
 * @property int $running_time
 * @property \Cake\I18n\Date|null $end_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Reservation[] $reservations
 * @property \App\Model\Entity\Schedule[] $schedules
 */
class Movie extends Entity
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
        'title' => true,
        'slideshow_img_path' => true,
        'screening_img_path' => true,
        'thumbnail_path' => true,
        'running_time' => true,
        'end_date' => true,
        'created' => true,
        'modified' => true,
        'reservations' => true,
        'schedules' => true,
    ];
}
