<?php

namespace App\Controller;

use DateTime;
use Exception; // added.

class CinemaSeatsReservationsController extends CinemaBaseController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Schedules');
        $this->loadModel('Seats');
        $this->loadModel('Movies');
        $this->loadModel('Reservations');
        $this->viewBuilder()->setLayout('quel_cinemas');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Days');
    }

    public function index($scheduleId = null)
    {

        try {
            $schedule = $this->Schedules->get($scheduleId, ['contain' => ['Movies']]);
        } catch (Exception $e) {
            return $this->redirect([
                'controller' => 'CinemaSchedules', 'action' => 'index'
            ]);
        }

        // scheduleにまとめる
        $start = $schedule['start_datetime'];
        $schedule['start'] = $this->Days->__getDayOfTheWeek($start) . $start->format('H:i');
        $end = $schedule['end_datetime'];
        $schedule['end'] = $end->format('H:i');


        //映画の開始時間が過ぎていないか
        $startDatetime = new DateTime($start);
        $now = new DateTime();
        if ($startDatetime < $now) {
            return $this->redirect([
                'controller' => 'CinemaSchedules', 'action' => 'index'
            ]);
        }

        //座席情報を取得
        $query = $this->Seats->find('all')
            ->where(['schedule_id' => $scheduleId, 'is_deleted' => false]);
        $query->enableHydration(false); // エンティティーの代わりに配列を返す
        $reservedSeats = $query->toList(); // クエリーを実行し、配列を返す

        //座席配置のjsonを取得
        $json = file_get_contents("js/seatLayout/data/layoutData.json");
        $layoutData = json_decode($json, true);

        //空席のみ
        $reservedSeatsLayout = $layoutData;

        foreach ($reservedSeats as $reservedSeat) {
            $seatNumber = $reservedSeat['seat_number'];
            $splitSeat = preg_split("/-/", $seatNumber);
            $gridSeatNumber = ord($splitSeat[0]) - 64; //アルファベットを数値に変換
            $gridRowId = $splitSeat[1];
            //seat_numberがある席を予約済みにステータスを変更
            $layoutData['seatLayout']['colAreas']['objArea'][0]['objRow'][$gridRowId - 1]['objSeat'][$gridSeatNumber - 1]['SeatStatus'] = "1";
        }
        $reservedSeatsLayout = $layoutData;
        $this->set(compact('reservedSeatsLayout', 'schedule', 'scheduleId'));
    }

    //複数予約は未対応
    public function done($scheduleId = null)
    {
        try {
            $schedule = $this->Schedules->get($scheduleId, ['contain' => ['Movies']]);
        } catch (Exception $e) {
            return $this->redirect([
                'controller' => 'CinemaSchedules', 'action' => 'index'
            ]);
        }

        //映画の開始時間が過ぎていないか
        $startDatetime = new DateTime($schedule['start_datetime']);
        $now = new DateTime();
        if ($startDatetime < $now) {
            return $this->redirect([
                'controller' => 'CinemaSchedules', 'action' => 'index'
            ]);
        }

        if ($this->request->is('post')) {
            $selectedSeat = $this->request->getData();
            //数値をアルファベット化
            $gridSeatChr = chr($selectedSeat['selected'][0]['GridSeatNum'] + 64);
            $gridRowId = $selectedSeat['selected'][0]['GridRowId'];
            //アルファベット-数値に結合
            $seat_number = $gridSeatChr . "-" . $gridRowId;

            $seats = $this->Seats->newEntity();
            $seats['seat_number'] = $seat_number;
            $seats['schedule_id'] = $scheduleId;

            //座席の重複がないか確認
            if ($this->Seats->find('all')
                ->where(['schedule_id' => $scheduleId, 'seat_number' => $seat_number, 'is_deleted' => false])
                ->first()
            ) {
                $this->Flash->error('その座席はすでに予約されています');
                return $this->redirect(['action' => 'index', $scheduleId]);
            }
            if ($this->Seats->save($seats)) {
                //セッションにscheduleを保存
                $schedule['seatNo'] = $seat_number;
                $session = $this->request->getSession();
                $session->write(['schedule' => $schedule, 'seat_id' => $seats['id']]);
            }
        }
        //不正なアクセスがあった場合
        return $this->redirect([
            'controller' => 'CinemaSchedules', 'action' => 'index'
        ]);
    }
}
