<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

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

        // 削除されていない認証ユーザーのクレジットカード情報をDBより取得
        $query = $this->Creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0]]]
        ])
            ->select('creditcard_number');

        $cardNum = $query->first();

        $cardNumLast4 = 0;
        if (!empty($cardNum)) {
            // 有効期限が切れたクレジットカードの処理
            $oldCard = $query->find('all', [
                'conditions' => ['expiration_date <' => Time::now()->year . '-' . Time::now()->month . '-1']
            ])
                ->first();

            // 有効期限がまだ来ていないクレジットカードの処理
            if (empty($oldCard)) {
                // クレジットカードの復号化
                $cardNumLast4 = substr($cardNum->decryptCreditcard_number($cardNum->creditcard_number), -4);
            } else {
                $cardNumLast4 = '有効期限が切れています';
            }
        }

        $this->set(compact('cardNumLast4'));
        $this->set(compact('point'));
    }
}
