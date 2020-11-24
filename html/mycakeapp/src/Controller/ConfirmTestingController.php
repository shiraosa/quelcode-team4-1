<?php

namespace App\Controller;

use App\Controller\AppController;

class ConfirmTestingController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Schedules');
        $this->loadComponent('Days');
    }

    public function index()
    {
        // GoPro, 11月19日(木)05:00~06:40
        $scheduleId = 19;
        $seatNo = 'A-1';

        $this->__testSubmit($scheduleId, $seatNo);
    }

    public function wed()
    {
        // 11月18日(水)00:00~01:40
        // 2000-11-11.で20歳, '05で15. '1950で70.
        $scheduleId = 1;
        // TODO:年齢は今日じゃなくてその日やで.
        // TODO:フォームの値が保持されていない
        $seatNo = 'B-1';

        $this->__testSubmit($scheduleId, $seatNo);
    }

    private function __testSubmit($scheduleId, $seatNo)
    {
        $schedule = $this->Schedules->get($scheduleId, ['contain' => ['Movies']]);
        $start = $schedule['start_datetime'];
        $schedule['start'] = $this->Days->__getDayOfTheWeek($start) . $start->format('H:i');
        $end = $schedule['end_datetime'];
        $schedule['end'] = $end->format('H:i');
        $schedule['seatNo'] = $seatNo;

        $session = $this->request->getSession();
        $session->write(['schedule' => $schedule]);

        return $this->redirect(['controller' => 'CinemaReservationConfirming', 'action' => 'index']);
    }
}
