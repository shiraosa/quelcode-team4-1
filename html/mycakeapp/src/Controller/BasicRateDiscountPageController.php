<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\I18n\Time;

class BasicRateDiscountPageController extends CinemaBaseController
{
    public function initialize()
    {
        // baseControllerで読み込んでたら削除
        parent::initialize();
        $this->loadModel('Basic_rates');
        $this->loadModel('Discount_types');
    }

    public function index()
    {
        // Basic_ratesテーブルから種類と基本料金を取得
        $rateInfos = $this->Basic_rates->find('all', [
            'conditions' => ['AND' => [['is_deleted' => 0], ['start_date <=' => Time::now()]]],
            'order' => ['basic_rate' => 'DESC']
        ])
            ->select(['ticket_type', 'basic_rate'])
            ->all();


        // Discount_typesテーブルから料金と割引詳細を取得
        $discountInfos = $this->Discount_types->find('all', [
            'conditions' => ['AND' => [['is_deleted' => 0], ['start_date <=' => Time::now()]]]
        ])
            ->select(['discount_type', 'discount_details', 'discount_price'])
            ->all();

        $this->set(compact('rateInfos'));
        $this->set(compact('discountInfos'));

        // baseController読み込んだら削除予定
        $this->viewBuilder()->setLayout('toppage');
    }

    //ログインなしで閲覧を許可
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index']);
    }
}
