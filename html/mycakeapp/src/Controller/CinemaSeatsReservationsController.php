<?php

namespace App\Controller;

use Cake\Chronos\Chronos;
use Cake\Event\Event;

class CinemaSeatsReservationsController extends CinemaBaseController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Schedules');
        $this->loadModel('Seats');
        $this->loadModel('Reservations');
        $this->viewBuilder()->setLayout('quel_cinemas');
        $this->loadComponent('RequestHandler');
    }

    //テスト
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index']);
    }
    public function index($scheduleId = null)
    {
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
            $layoutData['seatLayout']['colAreas']['objArea'][0]['objRow'][$gridRowId - 1]['objSeat'][$gridSeatNumber - 1]['SeatStatus'] = "1";
        }
        $reservedSeatsLayout = $layoutData;
        $this->set(compact('reservedSeatsLayout'));
    }
}
