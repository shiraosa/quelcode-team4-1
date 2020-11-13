<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Creditcard Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $owner_name
 * @property string $creditcard_number
 * @property \Cake\I18n\Date $expiration_date
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Payment[] $payments
 */
class Creditcard extends Entity
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
        'owner_name' => true,
        'creditcard_number' => true,
        'expiration_date' => true,
        'is_deleted' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'payments' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'creditcard_number',
    ];

    // クレジットカード番号の暗号化
    protected function _setCreditcard_number($encryptItem)
    {
        $key = 'HOGEhogeHOGEhogeHOGEhogeHOGEhoge';
        return openssl_encrypt($encryptItem, 'aes-256-ecb', $key);
    }
    // クレジットカード番号の復号化
    public function decryptCreditcard_number($decryptItem)
    {
        $key = 'HOGEhogeHOGEhogeHOGEhogeHOGEhoge';
        return openssl_decrypt($decryptItem, 'aes-256-ecb', $key);
    }

    // 有効期限mm/yyからdate型yyyy/mm/01に変換
    protected function _setExpiration_date($cardDate)
    {
        $expiration_date = '20' . substr($cardDate, -2) . '/' . substr($cardDate, 0, 2) . '/01';
        return $expiration_date;
    }
}
