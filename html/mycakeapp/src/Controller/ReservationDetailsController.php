<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class ReservationDetailsController extends CinemabaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Reservations');
        $this->loadModel('Seats');
        $this->loadModel('Movies');
        $this->loadModel('DiscountLogs');
        $this->loadModel('DiscountTypes');
        $this->loadModel('Schedules');
        $this->loadModel('Payments');
        $this->loadComponent('Days');
    }

    public function index()
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
            $tickets[$i]['start_date'] = $this->Days->__getDayOfTheWeek($reservation['schedule']['start_datetime']);
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

    public function delete()
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

                return $this->redirect(['action' => 'deleted']);
            }

            $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function deleted()
    {
    }

}
