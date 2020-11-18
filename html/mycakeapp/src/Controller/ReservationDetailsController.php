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
    }

    public function index()
    {
        // DBよりデータを取得
        $todayDatetime = date('Y-m-d H:i:s');
        $reservations = $this->Reservations->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.is_deleted' => 0], ['Schedules.end_datetime >' => $todayDatetime]]],
            'contain' => ['Seats', 'Movies', 'DiscountLogs', 'DiscountLogs.DiscountTypes', 'Schedules', 'Payments'],
        ])
            ->toArray();

        // データをindex.ctpへ渡すためにまとめる
        $i = 0;
        foreach ($reservations as $reservation) {
            $tickets[$i]['thumbnail_path'] = $reservation['movie']['thumbnail_path'];
            $tickets[$i]['title'] = $reservation['movie']['title'];
            $tickets[$i]['start_date'] = $reservation['schedule']['start_datetime']->format('m月d日');
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
    }

    public function deleted()
    {
    }
}
