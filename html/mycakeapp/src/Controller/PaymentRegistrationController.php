<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class PaymentRegistrationController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Creditcards');
        $this->viewBuilder()->setLayout('quel_cinemas');
    }

    public function index()
    {
        // クレジットカード情報をDBから取得
        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
            ])->first()
        ) {
            // クレジットカード登録済みのユーザーを決済情報確認画面へリダイレクト
            return $this->redirect(['controller' => '', 'action' => '']);
        }

        $creditcard = $this->Creditcards->newEntity();
        if ($this->request->is('post')) {
            $creditcard = $this->Creditcards->patchEntity($creditcard, $this->request->getData());
            // ユーザーIDをフォームデータに追加
            $creditcard->user_id = $this->Auth->user('id');

            if ($this->Creditcards->save(($creditcard))) {
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'done']);
            }

            $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
        }

        $this->set(compact('creditcard'));
    }

    public function done()
    {
    }
}
