<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

class CinemaPaymentController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('BasicRates');
        $this->loadModel('Creditcards');
        $this->loadModel('DiscountLogs');
        $this->loadModel('DiscountTypes');
        $this->loadModel('Movies');
        $this->loadModel('Payments');
        $this->loadModel('Reservations');
        $this->loadModel('Seats');
        $this->loadModel('Taxes');
        $this->loadModel('Users');
        $this->loadComponent('BaseFunction');
    }


    // 決済方法、ポイント選択
    public function index()
    {
        $session = $this->request->getSession();

        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
            ])->first()
        ) {
            if ($this->request->is('post')) {
                $usePoint = 0;
                $session->write(['usePoint' => $usePoint]);
                return $this->redirect(['action' => 'details']);
            }
            // セッターによりもとのプロパティにいれると暗号化＆日付がymdになってしまう。
            $cardNumber = $creditcard->decryptCreditcard_number($creditcard->creditcard_number);
            $cardNumLast4 = substr($cardNumber, -4);
            $cardBrand = $creditcard->takeCardBland($cardNumber);
            $cardDate = $creditcard->changeCardDate($creditcard->expiration_date);
            $cardOwner = $creditcard->owner_name;

            $havePoint = 0;
            $this->set(compact('cardNumLast4', 'cardBrand', 'cardDate', 'cardOwner', 'havePoint'));
        } else {
            $session = $this->request->getSession();
            $session->write('creditcard', 'registration');
            return $this->redirect(['controller' => 'CinemaCreditcard', 'action' => 'add']);
        }
    }


    public function details()
    {
        $session = $this->request->getSession();
        if (!($session->check('usePoint'))) {
            return $this->redirect(['controller' => 'CinemaSchedules']);
        }

        $point = 0;

        $basicRate = $this->BasicRates->get($session->read('profile')['type']);
        $basicRatePrice = $basicRate->basic_rate;

        $discount = [];

        if ($session->read('discountTypeId')) {

            $discount = $this->DiscountTypes->get($session->read('discountTypeId'));
            $discount['type'] = $discount->discount_type;

            if (0 < $discount->discount_price) {
                // 一定額になる割引の場合の処理（雨の日、複数人など）
                // $discountPrice =
            } else {
                $discount['price'] = abs($discount->discount_price);
                $totalPayment = $basicRatePrice + $discount->discount_price;
            }
        } else {
            $totalPayment = $basicRatePrice;
        }
        $totalPayment -= $point;
        $session->write(['totalPayment' => $totalPayment]);

        $this->set(compact('basicRatePrice', 'point', 'discount', 'totalPayment'));
    }


    public function save()
    {
        $session = $this->request->getSession();
        if (!($session->check('totalPayment'))) {
            return $this->redirect(['controller' => 'CinemaSchedules']);
        }

        $payment = $this->Payments->newEntity();
        $reservation = $this->Reservations->newEntity();
        $discountLog = $this->DiscountLogs->newEntity();

        // 決済情報を取得し保存
        $creditcard = $this->Creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
        ])->first();
        $payment->creditcard_id = $creditcard->id;

        // 適用開始日を迎えた税率の中で一番新しいものを取得
        $tax = $this->Taxes->find('all', [
            'conditions' => ['start_date <=' => Time::now()],
            'order' => ['start_date' => 'DESC']
        ])->first();
        $payment->tax_id = $tax->id;
        $payment->total_payment = $session->read('totalPayment');
        $payment->is_deleted = 0;

        // $connection = ConnectionManager::get('default');
        // $connection->begin();
        if (($this->Payments->save($payment))) {

            // 予約情報を取得し保存
            $reservation->user_id = $this->Auth->user('id');
            $reservation->seat_id = $session->read('seat_id');
            $reservation->schedule_id = $session->read('schedule')['id'];
            $reservation->movie_id = $session->read('schedule')['movie_id'];
            $reservation->payment_id = $payment->id;
            $reservation->basic_rate_id = $session->read('profile')['type'];
            $reservation->is_deleted = 0;

            if ($this->Reservations->save($reservation)) {

                // 割引情報を取得し保存
                if ($session->check('discountTypeId')) {
                    $discountLog->reservation_id = $reservation->id;
                    $discountLog->discount_type_id = $session->read('discountTypeId');
                    $discountLog->is_deleted = 0;
                    if ($this->DiscountLogs->save($discountLog)) {
                    } else {
                        // $connection->rollback();
                        return $this->redirect(['action' => 'details']);
                    }
                }
                $this->Flash->success(__('The payment has been saved.'));
                // $connection->commit();
                return $this->redirect(['action' => 'completed']);
            }
        }
        // $connection->rollback();
        $this->redirect(['action' => 'details']);
    }
    public function cancel()
    {
        $this->redirect(['controller' => 'CinemaSchedules']);
    }
    public function completed()
    {
    }
}
