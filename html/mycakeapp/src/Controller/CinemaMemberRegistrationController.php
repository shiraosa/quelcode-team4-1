<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Exception;

class CinemaMemberRegistrationController extends CinemaBaseController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'done']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function done()
    {
    }

    //ログインなしで閲覧を許可
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'done']);
    }
}
