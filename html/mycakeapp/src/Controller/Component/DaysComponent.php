<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class DaysComponent extends Component
{
    public function __getDayOfTheWeek($day)
    {
        $weekday = ['日', '月', '火', '水', '木', '金', '土'];
        $w = $weekday[$day->format('w')];
        $day = $day->format("m月d日($w)");

        return $day;
    }
}
