<?php

namespace App\Controller;

class CinemaReservationConfirmingController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('quel_cinemas');
    }

    public function index()
    {
        $this->set('hoge');
    }
}
