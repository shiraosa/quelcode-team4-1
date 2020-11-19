<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

class MypageController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Creditcards');
        $this->loadModel('Users');
        $this->loadModel('Reservations');
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

    // アカウント削除
    public function delete()
    {
        // キャンセルしてない予約情報を確認
        $todayDatetime = date('Y-m-d H:i:s');
        if (
            $reservation = $this->Reservations->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.is_deleted' => 0], ['Schedules.end_datetime >' => $todayDatetime]]],
                'contain' => ['Schedules']
            ])->first()
        ) {
        } else {
            // ユーザーレコードに予約情報がなければ削除フラグを立てる
            $myAccount = $this->Users->get($this->Auth->user('id'));
            $myAccount->is_deleted = 1;
            // 削除してないクレジットカードがあればレコードに削除フラグを立てる
            if (
                $creditcard = $this->Creditcards->find('all', ['conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0]]]])->first()
            ) {
                $creditcard->is_deleted = 1;
            }
            if ($this->Users->save($myAccount)) {
                if (!empty($creditcard)) {
                    $this->Creditcards->save($creditcard);
                }
                $this->Flash->success(__('The creditcard & user has been saved.'));

                return $this->redirect(['action' => 'deleted']);
            }
        }

        return $this->redirect(['action' => 'index']);
    }
    // アカウント削除完了
    public function deleted()
    {
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['deleted']);
    }
}
