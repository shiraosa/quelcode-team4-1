<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class BaseFunctionComponent extends Component
{
    /**
     * dateObjectをstrに変換する
     *
     * m月d日(曜日)を出力する
     *
     * @param obj $day
     * @return str $day
     */
    public function __getDayOfTheWeek($day)
    {
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $w = $weekday[$day->format('w')];
        $day = $day->format("m月d日($w)");

        return $day;
    }
    
    /**
     * Undocumented function
     * 一連の予約処理で使われる各セッションの削除
     *
     * @param [type] $session $this->request->getSession()したものを引数とする
     * @return void なし
     */
    public function deleteSessionReservation($session)
    {
        $session->delete('schedule');
        $session->delete('profile');
        $session->delete('discountTypeId');
        $session->delete('price');
        $session->delete('creditcard');
        $session->delete('point');
        $session->delete('totalPayment');
        $session->delete('todayWeather');

        // 座席テーブルに削除フラグを立てる
        if (($session->check('seat_id')) && (($session->read('completed') === null))) {
            $seatsTable = TableRegistry::getTableLocator()->get('Seats');
            $seat = $seatsTable->get($session->read('seat_id'));
            $seat->is_deleted = 1;
            $seatsTable->save($seat);
        }
        $session->delete('completed');
        $session->delete('seat_id');
    }

    /**
     * Undocumented function
     * 認証ユーザーの使用可能なクレジットカード情報を検索します
     *
     * @param [type] $userId 認証ユーザーIDを引数とする
     * @return void 使用可能なクレジットカード情報 || null
     */
    public function aliveCreditcard($userId)
    {
        $creditcards = TableRegistry::getTableLocator()->get('Creditcards');
        $aliveCredit = $creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $userId], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
        ])->first();
        return $aliveCredit;
    }

    /**
     * Undocumented function
     * 認証ユーザーのポイント情報を検索します。
     *
     * @param [type] $userId 認証ユーザーを引数とする
     * @return void ポイントの使用、獲得情報 || null
     */
    public function pointInfo($userId)
    {
        $points = TableRegistry::getTableLocator()->get('Points');
        $point['info'] = $points->find('all', [
            'conditions' => ['AND' => [['user_id' => $userId], ['is_deleted' => 0]]],
            'order' => ['created' => 'DESC']
        ])->toArray();

        if (!empty($point['info'])) {
            // 現在の保有ポイントの計算
            $getPoint = 0;
            $usePoint = 0;
            foreach ($point['info'] as $info) {
                $getPoint += $info->get_point;
                $usePoint += $info->use_point;
            }

            $point['havePoint'] = $getPoint - $usePoint;
        } else {
            $point['havePoint'] = 0;
        }

        return $point;
    }
}
