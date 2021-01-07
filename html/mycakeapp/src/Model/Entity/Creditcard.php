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
        $encryptItem = str_replace(array(" ", "　"), "", $encryptItem);
        $key = 'HOGEhogeHOGEhogeHOGEhogeHOGEhoge';
        return openssl_encrypt(($encryptItem), 'aes-256-ecb', $key);
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
    // 有効期限date型yyyy/mm/01からmm/yyに変換
    public function changeCardDate($ymd)
    {
        $myDate = date('m/y', strtotime($ymd));
        return $myDate;
    }

    public function takeCardBland($cardNumber) {

        if (1 === preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cardNumber)) {
            //VISA
            //4で始まる13桁か16桁の数値
            $cardBrand = 'VISA';
        } elseif (1 === preg_match('/^5[1-5][0-9]{14}$/', $cardNumber)) {
            //MasterCard
            //51～55で始まる16桁の数値
            $cardBrand = 'MasterCard';
        } elseif (1 === preg_match('/^6011[0-9]{12}$/', $cardNumber)) {
            //Discover Card
            //6011から始まる16桁の数値
            $cardBrand = 'Discover Card';
        } elseif (1 === preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $cardNumber)) {
            //Diners Club
            //300-305、360-369、380-389で始まる14桁の数値
            $cardBrand = 'Diners Club';
        } elseif (1 === preg_match('/^3[47][0-9]{13}$/', $cardNumber)) {
            //American Express
            //34か37で始まる15桁の数値
            $cardBrand = 'American Express';
        } elseif (1 === preg_match('/^(?:2131|1800|35[0-9]{3})[0-9]{11}$/', $cardNumber)) {
            //JCB Card
            //2131か1800で始まる15桁の数値 或いは 35で始まる16桁の数値
            $cardBrand = 'JCB Card';
        } else {
            $cardBrand = 'another';
        }
        return $cardBrand;
    }
}
