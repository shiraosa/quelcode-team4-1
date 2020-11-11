<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\Utility\Security;

class MypageController extends CinemaBaseController
{
    public function initialize()
    {
        // baseControllerで読み込んでたら削除
        parent::initialize();
        $this->loadModel('Creditcards');
    }

    public function index()
    {
        // ポイント機能は任意課題のため、仮定0pt
        $point = 0;

        // クレジットカード情報をDBより取得
        $todayDate = date('Y-m-d');
        $encryptedCardNum = $this->Creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => $todayDate]]]
        ])
            ->select('creditcard_number')
            ->first();

        $cardNumLast4 = 0;
        if (!empty($encryptedCardNum)) {
            $cardNum = $encryptedCardNum->creditcard_number;
            // 暗号化機能が実装されたときに下記を実装
            // $key = '暗号キー';
            // $cardNum = Security::decrypt($encryptedCardNum->creditcard_number, $key);

            $cardNumLast4 = substr($cardNum, -4);
        }

        $this->set(compact('cardNumLast4'));
        $this->set(compact('point'));
    }
}
