<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class PaymentRegistrationController extends AppController
{
    public function initialize()
    {
        // baseControllerで読み込んでたら削除
        parent::initialize();
        $this->loadModel('Creditcards');
        $this->viewBuilder()->setLayout('quel_cinemas');
    }

    public function index()
    {
        // 認証情報よりユーザーIDを取得、仮でuser_id = 1を使用
        $userId = 2;
        // クレジットカード情報をDBから取得
        if (
        $creditcard = $this->Creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $userId], ['is_deleted' => 0], ['expiration_date >=' => Time::now()]]]
        ])->first()
        ) {
            return $this->redirect(['controller' => '', 'action' => '']);
        }

        $creditcard = $this->Creditcards->newEntity();
        if ($this->request->is('post')) {
            $creditcard = $this->Creditcards->patchEntity($creditcard, $this->request->getDate());
            if ($this->Creditcards->save($creditcard)) {
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'done']);
            }
            $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
        }
        $this->set(compact('creditcard'));
        $this->set('_serialize', ['user']);
    }

    public function done()
    {
    }
}
