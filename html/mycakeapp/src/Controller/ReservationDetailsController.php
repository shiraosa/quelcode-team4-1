<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class ReservationDetailsController extends CinemabaseController
{
    public function initialize()
    {
        // baseControllerで読み込んでたら削除
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
        // dd(Time::now());
        $reservations = $this->Reservations->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['Reservations.is_deleted' => 0], ['Schedules.end_datetime >' => Time::now()]]],
            'contain' => ['Seats', 'Movies', 'DiscountLogs', 'DiscountLogs.DiscountTypes', 'Schedules', 'Payments'],
        ])->select(['Seats.seat_number', 'Movies.title', 'Movies.thumbnail_path', 'DiscountLogs.DiscountTypes.discount_type', 'Schedules.start_datetime', 'Schedules.end_datetime'])
            ->all();
        dd($reservations);

        $this->set(compact('reservations'));
    }

    public function delete()
    {
    }

    public function deleted()
    {
    }
}
