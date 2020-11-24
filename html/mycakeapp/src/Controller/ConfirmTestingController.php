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
        // 11月24日(火)00:00~01:40
        // 2000で20歳, '05で15. '1950で70.
        $scheduleId = 61;
        $seatNo = 'A-1';

        $this->__testSubmit($scheduleId, $seatNo);
    }

    public function wed()
    {
        // 11月25日(水)00:00~01:40
        // 子供女性シニア割引, ... 'female') || ($age <= 15) || ($age >= 70)
        $scheduleId = 62;
        $seatNo = 'B-1';

        $this->__testSubmit($scheduleId, $seatNo);
    }

    public function first()
    {
        // 12月01日(水)00:00~01:40
        // ファーストデイ割引, 誰でも500yenオフ
        $scheduleId = 63;
        $seatNo = 'C-1';

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
