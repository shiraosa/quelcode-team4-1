<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\Entity;

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
        $cardNum = $this->Creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
        ])
            ->select('creditcard_number')
            ->first();

        $cardNumLast4 = 0;
        if (!empty($cardNum)) {
            $cardNumLast4 = substr($cardNum->decryptCreditcard_number($cardNum->creditcard_number), -4);
        }

        $this->set(compact('cardNumLast4'));
        $this->set(compact('point'));
    }
}
