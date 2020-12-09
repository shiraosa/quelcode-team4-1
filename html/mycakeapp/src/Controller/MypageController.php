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
    }

    public function index()
    {
        // 予約、決済処理中にマイページリンクを押下した場合の処理
        $session = $this->request->getSession();
        $this->BaseFunction->deleteSessionReservation($session);

        // ポイント機能は任意課題のため、仮定0pt
        $point = $this->BaseFunction->pointInfo($this->Auth->user('id'));

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

        $todayDatetime = date('Y-m-d H:i:s');
        if (
            $this->Reservations->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.is_deleted' => 0], ['Schedules.end_datetime >' => $todayDatetime]]],
                'contain' => ['Schedules']
            ])->first()
        ) {
            $haveReservation = true;
        } else {
            $haveReservation = false;
        }

        $this->set(compact('cardNumLast4', 'point', 'haveReservation'));
    }

    // ポイント獲得履歴
    public function point()
    {
        $point = $this->BaseFunction->pointInfo($this->Auth->user('id'));

        $this->set(compact('point'));
    }

    public function checkReservation()
    {
        $tickets = [];
        // DBよりデータを取得
        $todayDatetime = date('Y-m-d H:i:s');
        $reservations = $this->Reservations->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.is_deleted' => 0], ['Schedules.end_datetime >' => $todayDatetime], ['Schedules.is_deleted' => '0']]],
            'contain' => ['Seats', 'Movies', 'DiscountLogs', 'DiscountLogs.DiscountTypes', 'Schedules', 'Payments'],
            'order' => (['Schedules.start_datetime' => 'DESC', 'Movies.title' => 'DESC', 'Seats.seat_number' => 'DESC'])
        ])
            ->toArray();

        // データをindex.ctpへ渡すためにまとめる
        $i = 0;
        foreach ($reservations as $reservation) {
            $tickets[$i]['id'] = $reservation['id'];
            $tickets[$i]['thumbnail_path'] = $reservation['movie']['thumbnail_path'];
            $tickets[$i]['title'] = $reservation['movie']['title'];
            $tickets[$i]['start_date'] = $this->BaseFunction->__getDayOfTheWeek($reservation['schedule']['start_datetime']);
            $tickets[$i]['start_time'] = $reservation['schedule']['start_datetime']->format('H:i');
            $tickets[$i]['end_time'] = $reservation['schedule']['end_datetime']->format('H:i');
            $tickets[$i]['seat'] = $reservation['seat']['seat_number'];
            $tickets[$i]['fee'] = $reservation['payment']['total_payment'];
            if (!empty($reservation['discount_logs'][0]['discount_type']['discount_type'])) {
                $tickets[$i]['discount_type'] = $reservation['discount_logs'][0]['discount_type']['discount_type'];
            } else {
                $tickets[$i]['discount_type'] = null;
            }
            $i++;
        }

        $this->set(compact('tickets'));
    }

    public function deleteReservation()
    {
        $reservation_id = $this->request->getQuery('id');
        if (!empty($reservation_id)) {
            $reservation = $this->Reservations->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.id' => $reservation_id]]],
                'contain' => ['DiscountLogs']
            ])->first();
            $reservation->is_deleted = 1;
            // 座席レコードに削除フラグを設定
            $seat = $this->Seats->get($reservation->seat_id);
            $seat->is_deleted = 1;
            // 決済レコードに削除フラグを設定
            $payment = $this->Payments->get($reservation->payment_id);
            $payment->is_deleted = 1;
            // 割引があれば割引テーブルに削除フラグを設定
            if (!empty($reservation->discount_logs)) {
                $discountLog = $this->DiscountLogs->find('all', [
                    'conditions' => ['reservation_id' => $reservation->id]
                ])->first();
                $discountLog->is_deleted = 1;
            }
            if (($this->Reservations->save($reservation)) && ($this->Seats->save($seat)) && ($this->Payments->save($payment))) {
                if (!empty($reservation->discount_logs)) {
                    $this->DiscountLogs->save($discountLog);
                }
                $this->Flash->success(__('The reservation has been saved.'));

                return $this->redirect(['action' => 'deletedReservation']);
            }

            $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
        } else {
            return $this->redirect(['action' => 'checkReservation']);
        }
    }

    public function deletedReservation()
    {
    }


    // アカウント削除
    public function deleteAccount()
    {
        // キャンセルしてない予約情報を確認
        $todayDatetime = date('Y-m-d H:i:s');
        if (
            $this->Reservations->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.is_deleted' => 0], ['Schedules.end_datetime >' => $todayDatetime]]],
                'contain' => ['Schedules']
            ])->first()
        ) {
            return $this->redirect(['action' => 'checkReservation']);
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

                $session = $this->getRequest()->getSession();
                $session->destroy();
                return $this->redirect(['action' => 'deletedAccount']);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    // アカウント削除完了
    public function deletedAccount()
    {
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['deleted']);
    }
}
