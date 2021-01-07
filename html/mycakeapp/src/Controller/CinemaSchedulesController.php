<?php

namespace App\Controller;

use Cake\Chronos\Chronos;
use Cake\Event\Event;

class CinemaSchedulesController extends CinemaBaseController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index']);
    }

    public function index()
    {

        $session = $this->request->getSession();
        $this->BaseFunction->deleteSessionReservation($session);

        // 日付の取得
        $now = Chronos::now();
        $length = 7;
        $days = $this->__getDays($now, $length);

        // URLパラメータの取得, 検証
        $daySelected = $this->request->getQuery('date');
        $nowYmd = $now->format('Y-m-d');
        $limit = $now->addDays(6);

        if (strptime($daySelected, '%Y-%m-%d') && Chronos::parse($daySelected)->between($now, $limit)) {
            $nowYmd = $daySelected;
        } else {
            $daySelected = $now;
        }

        // queryの共通部分
        $query = $this->Schedules->find()
            ->where([
                'Schedules.start_datetime >=' => $daySelected,
                'Schedules.start_datetime <=' => "$nowYmd 23:59:59",
                'Schedules.is_deleted' => false
            ]);

        // 映画情報を取得する
        $movies = $query
            ->cleanCopy()
            ->contain(['Movies'])
            ->select(['Movies.id', 'Movies.title', 'Movies.thumbnail_path', 'Movies.running_time', 'Movies.end_date', 'count' => $query->func()->count('Schedules.movie_id')])
            ->group('Schedules.movie_id')
            ->order(['count' => 'DESC'])
            ->toArray();

        // スケジュールを取得する
        $schedules = $query
            ->select(['Schedules.id', 'Schedules.movie_id', 'Schedules.start_datetime', 'Schedules.end_datetime'])
            ->toArray();

        // moviesObjectにスケジュールからの取得情報をまとめる
        foreach ($movies as $value) {
            $value['movie']['running_time'] = '[ 上映時間：' . $value['movie']['running_time'] . '分 ]';
            $value['movie']['end_date'] = $value['movie']['end_date']
                ? $this->BaseFunction->__getDayOfTheWeek(Chronos::parse($value['movie']['end_date'])) . '終了予定' : '';
            $scheduleSet = [];
            foreach ($schedules as $schedulesValue) {
                if ($value['movie']['id'] === $schedulesValue['movie_id']) {
                    $id = $schedulesValue['id'];
                    $start = $schedulesValue['start_datetime']->format('H:i');
                    $end = $schedulesValue['end_datetime']->format('H:i');
                    $scheduleSet[$id][$start] = $end;
                }

                $value['movie']['scheduleSet'] = $scheduleSet;
            }
        }

        $this->set(compact('days', 'nowYmd', 'movies'));
    }


    private function __getDays($day, int $length)
    {
        for ($i = 0; $i < $length; $i++) {
            $discountType = (($day->isWednesday()) ? '子供女性シニア割引' : '')
                ?: (($day->day === 1) ? 'ファーストデイ割引' : '');
            $date = $day->format("Y-m-d");
            $schedule = $this->BaseFunction->__getDayOfTheWeek($day);
            //本日の天気情報を取得。東京はTokyo
            if ($i === 0 && $this->__getRain('Tokyo')) {
                $days[$date][$schedule] = $discountType . "雨の日割引";
            } else {
                $days[$date][$schedule] = $discountType;
            }
            $day = $day->addDay();
        }

        return $days;
    }

    function __getRain($cityName)
    {
        $api_url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $cityName . '&units=metric&appid=4b5774e9f3d2a07b84f0f2f88e486224';
        $weather = json_decode(file_get_contents($api_url), true);
        //雨をRain,ThunderStorm,Drizzleと定義。雪は適用外
        if ($weather['weather'][0]['id'] >= 200 && $weather['weather'][0]['id'] <= 599) {
            //雨ならセッションに保存
            $session = $this->request->getSession();
            $session->write(['todayWeather' => 'Rain']);

            return true;
        }
    }
}
