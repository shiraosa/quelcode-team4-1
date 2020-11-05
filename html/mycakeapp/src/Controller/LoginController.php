<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Exception;

class LoginController extends AppController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Users');
        $this->viewBuilder()->setLayout('quel_cinemas');
    }

    public function index()
    {
    }
}
