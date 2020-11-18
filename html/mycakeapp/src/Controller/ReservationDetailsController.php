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
            'order' => (['Schedules.start_datetime' => 'asc', 'Movies.title' => 'asc', 'Seats.seat_number' => 'asc'])
        ])
            ->toArray();

        // データをindex.ctpへ渡すためにまとめる
        $i = 0;
        foreach ($reservations as $reservation) {
            $tickets[$i]['id'] = $reservation['id'];
            $tickets[$i]['thumbnail_path'] = $reservation['movie']['thumbnail_path'];
            $tickets[$i]['title'] = $reservation['movie']['title'];
            $tickets[$i]['start_date'] = $this->__getDayOfTheWeek($reservation['schedule']['start_datetime']);
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
        if ($this->request->is('get')) {
            $reservation_id = $this->request->getQuery('id');
            $reservation = $this->Reservations->find('all', [
                'contains' => ['AND' => ['user_id' => $this->Auth->user('id')], ['id' =>$reservation_id]],
                'contain' => ['Seats', 'Movies', 'DiscountLogs', 'DiscountLogs.DiscountTypes', 'Schedules', 'Payments']
            ])->toArray();
            $reservation['is_deleted'] = 1;
            $reservation['seat']['is_deleted'] = 1;
            $reservation['payment']['is_deleted'] = 1;
            $reservation['discount_log']['is_deleted'] = 1;
            dd($reservation);
            if ($this->Reservations->save(($reservation))) {
                $this->Flash->success(__('The reservation has been saved.'));

                return $this->redirect(['action' => 'deleted']);
            }

            $this->Flash->error(__('The reservation could not be saved. Please, try again.'));
        }
    }

    public function deleted()
    {
    }

    private function __getDayOfTheWeek($day)
    {
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $w = $weekday[$day->format('w')];
        $day = $day->format("m月d日($w)");

        return $day;
    }
}
