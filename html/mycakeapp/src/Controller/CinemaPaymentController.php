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
    }

    // 決済方法、ポイント選択
    public function index()
    {
        if (
            $creditcard = $this->Creditcards->find('all', [
                'conditions' => ['AND' => [['user_id' => $this->Auth->user('id')], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
            ])->first()
        ) {
            // セッターによりもとのプロパティにいれると暗号化＆日付がymdになってしまう。
            $cardNumber = $creditcard->decryptCreditcard_number($creditcard->creditcard_number);
            $cardNumLast4 = substr($cardNumber, -4);
            $cardBrand = $creditcard->takeCardBland($cardNumber);
            $cardDate = $creditcard->changeCardDate($creditcard->expiration_date);
            $cardOwner = $creditcard->owner_name;

            $point = 0;
            $this->set(compact('cardNumLast4', 'cardBrand', 'cardDate', 'cardOwner', 'point'));
        } else {
            $session = $this->request->getSession();
            $session->write('creditcard', 'registration');
            return $this->redirect(['controller' => 'CinemaCreditcard', 'action' => 'add']);
        }
    }

    public function details()
    {

        $ticketFee = 1800;
        $point = 0;
        $discountType = 'レディースデー';
        $discountPrice = 300;
        $totalPayment = $ticketFee - $discountPrice;

        $this->set(compact('ticketFee', 'point', 'discountType', 'discountPrice', 'totalPayment'));
    }
    public function save()
    {


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
        // $payment->total_payment =
        $payment->is_deleted = 0;

        $connection = ConnectionManager::get('default');
        // dd($connection);
        $connection->begin();
        if (($this->Payments->save($payment))) {

            // 予約情報を取得し保存
            $reservation->user_id = $this->Auth->user('id');
            // $reservation->seat_id =
            // $reservation->schedule_id =
            // $reservation->movie_id =
            $reservation->payment_id = $this->Payments->getLastInsertID();
            // $reservation->basic_rate_id =
            $reservation->is_deleted = 0;

            if ($this->Reservations->save($reservation)) {

                // 割引情報を取得し保存
                if (!empty($discountLog)) {
                    $discountLog->payment_id = $this->Reservations->getLastInsertID();
                    // $discountLog->discount_type_id =
                    $discountLog->is_deleted = 0;
                    if ($this->DiscountLogs->save($discountLog)) {
                    } else {
                        $connection->rollback();
                        return $this->redirect(['action' => 'details']);
                    }
                }
                $this->Flash->success(__('The payment has been saved.'));
                $connection->commit();
                return $this->redirect(['action' => 'completed']);
            }
        }
        $connection->rollback();
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
