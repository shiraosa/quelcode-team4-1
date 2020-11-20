<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class CinemaCreditcardController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Creditcards');
        $this->viewBuilder()->setLayout('quel_cinemas');
    }

    public function add()
    {
        // クレジットカード情報をDBから取得
        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
            ])->first()
        ) {
            // クレジットカード登録済みのユーザーを決済情報確認画面へリダイレクト
            return $this->redirect(['action' => 'index']);
        }

        $creditcard = $this->Creditcards->newEntity();
        if ($this->request->is('post')) {
            $creditcard = $this->Creditcards->patchEntity($creditcard, $this->request->getData());
            // ユーザーIDをフォームデータに追加
            $creditcard->user_id = $this->Auth->user('id');
            $creditcard->is_deleted = 0;

            if ($this->Creditcards->save(($creditcard))) {
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'completed']);
            }

            $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
        }

        $this->set(compact('creditcard'));
    }

    public function edit()
    {
        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0]]]
            ])->first()
        ) {
            if ($this->request->is('post')) {
                $creditcard = $this->Creditcards->patchEntity($creditcard, $this->request->getData());
                if ($this->Creditcards->save(($creditcard))) {
                    $this->Flash->success(__('The creditcard has been saved.'));

                    return $this->redirect(['action' => 'completed']);
                }

                $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
            }
            // セッターによりもとのプロパティにいれると暗号化＆日付がymdになってしまう。
            $cardNumber = $creditcard->decryptCreditcard_number($creditcard->creditcard_number);
            $cardDate = $creditcard->changeCardDate($creditcard->expiration_date);
            $creditcard->creditcard_number = 0;
            $this->set(compact('creditcard'));
            $this->set(compact('cardNumber'));
            $this->set(compact('cardDate'));
        } else {
            // 削除のされてないクレジットカード情報を持たないユーザーは決済情報登録画面は遷移
            return $this->redirect(['action' => 'add']);
        }
    }
    public function index()
    {
        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0]]]
            ])->first()
        ) {
            // セッターによりもとのプロパティにいれると暗号化＆日付がymdになってしまう。
            $cardNumber = $creditcard->decryptCreditcard_number($creditcard->creditcard_number);
            $cardBrand = $creditcard->takeCardBland($cardNumber);
            $cardNumLast4 = substr($cardNumber, -4);
            $creditcard->creditcard_number = 0;

            $this->set(compact('cardBrand'));
            $this->set(compact('creditcard'));
            $this->set(compact('cardNumLast4'));
        } else {
            // 削除のされてないクレジットカード情報を持たないユーザーは決済情報登録画面は遷移
            return $this->redirect(['action' => 'add']);
        }
    }
    public function delete()
    {
        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0]]]
            ])->first()
        ) {
            $creditcard->is_deleted = 1;
            if ($this->Creditcards->save(($creditcard))) {
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'deleted']);
            }

            $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
        } else {
            // 削除のされてないクレジットカード情報を持たないユーザーは決済情報登録画面は遷移
            return $this->redirect(['action' => 'add']);
        }
    }
    public function completed()
    {
    }
    public function deleted()
    {
    }
}
