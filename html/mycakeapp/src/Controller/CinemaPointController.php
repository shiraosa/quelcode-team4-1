<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

class CinemaPointController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Points');
        $this->loadComponent('BaseFunction');
    }

    // ポイント獲得履歴
    public function index()
    {
        $point = $this->BaseFunction->pointInfo($this->Auth->user('id'));

        // dd($point);
        $this->set(compact('point'));
    }
}
