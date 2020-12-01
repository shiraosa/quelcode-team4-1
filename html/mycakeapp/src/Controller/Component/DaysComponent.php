<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * 曜日の関数
 */

class DaysComponent extends Component
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
}
