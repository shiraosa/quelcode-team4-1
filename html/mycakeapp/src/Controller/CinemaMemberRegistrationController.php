<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Exception;

class CinemaMemberRegistrationController extends AppController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Users');
        $this->viewBuilder()->setLayout('cinema');
    }

    public function index()
    {
    }
}
