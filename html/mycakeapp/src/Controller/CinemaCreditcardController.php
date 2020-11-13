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
            return $this->redirect(['action' => 'check']);
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
            $cardBrand = 'visa';
            $cardNumLast4 = substr($cardNumber, -4);
            $cardDate = $creditcard->changeCardDate($creditcard->expiration_date);
            $creditcard->creditcard_number = 0;

            if (1 === preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cardNumber)) {
                //VISA
                //4で始まる13桁か16桁の数値
                $cardBrand = 'VISA';
            } elseif (1 === preg_match('/^5[1-5][0-9]{14}$/', $cardNumber)) {
                //MasterCard
                //51～55で始まる16桁の数値
                $cardBrand = 'MasterCard';
            } elseif (1 === preg_match('/^6011[0-9]{12}$/', $cardNumber)) {
                //Discover Card
                //6011から始まる16桁の数値
                $cardBrand = 'Discover Card';
            } elseif (1 === preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $cardNumber)) {
                //Diners Club
                //300-305、360-369、380-389で始まる14桁の数値
                $cardBrand = 'Diners Club';
            } elseif (1 === preg_match('/^3[47][0-9]{13}$/', $cardNumber)) {
                //American Express
                //34か37で始まる15桁の数値
                $cardBrand = 'American Express';
            } elseif (1 === preg_match('/^(?:2131|1800|35[0-9]{3})[0-9]{11}$/', $cardNumber)) {
                //JCB Card
                //2131か1800で始まる15桁の数値 或いは 35で始まる16桁の数値
                $cardBrand = 'JCB Card';
            } else {
                $cardBrand = 'another';
            }

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
            // dd($creditcard);
            if ($this->Creditcards->save(($creditcard))) {
                // dd("saveのあと");
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'deleted']);
            }
            // dd('saveされてない');

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
