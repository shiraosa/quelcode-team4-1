<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\ORM\Table;

class QuelCinemasController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {

        $session = $this->request->getSession();
        $this->BaseFunction->deleteSessionReservation($session);

        // 上映映画画像をDBより取得
        $todayDate = date('Y-m-d');
        $screeningMovies = $this->Movies
            ->find()
            ->select(['screening_img_path'])
            ->where([
                'OR' => [['end_date IS' => NULL], ['end_date >=' => $todayDate]]
            ]);
        $x = 0;
        foreach ($screeningMovies as $mvImg) {
            $screenings[$x] = $mvImg->screening_img_path;
            $x++;
        }

        // スライドショーに使う画像を今後のスケジュールで上演回数の多い順3つをDBより取得
        $todayDatetime = date('Y-m-d H:i:s');
        $top3MoviesIdDesc = $this->Schedules
            ->find()
            ->select(['cnt_movie_id' => $this->Schedules->find()->func()->count('movie_id'), 'movie_id'])
            ->where(['AND' => [['start_datetime >' => $todayDatetime], ['is_deleted' => 0]]])
            ->group('movie_id')
            ->order(['cnt_movie_id' => 'DESC'])
            ->limit(3);
        $y = 0;
        foreach ($top3MoviesIdDesc as $mvId) {
            $top3MoviesId[$y] = $mvId->movie_id;
            $y++;
        }
        $top3Slideshow = $this->Movies
            ->find()
            ->select(['slideshow_img_path'])
            ->where(['id IN' => $top3MoviesId]);
        $z = 0;
        foreach ($top3Slideshow as $slide) {
            $slideshows[$z] = $slide->slideshow_img_path;
            $z++;
        }


        // 割引バナーをDBより取得
        $discountTypesTable = $this->DiscountTypes
            ->find()
            ->select(['banner_path'])
            ->where(['is_deleted' => 0]);

        $i = 1;
        foreach ($discountTypesTable as $discount) {
            $banners[$i] = $discount->banner_path;
            $i++;
        }

        $this->set(compact('screenings'));
        $this->set(compact('slideshows'));
        $this->set(compact('banners'));

        // 使用レイアウト変更
        $this->viewBuilder()->setLayout('toppage');
    }


    public function price()
    {
        $session = $this->request->getSession();
        $this->BaseFunction->deleteSessionReservation($session);

        // Basic_ratesテーブルから種類と基本料金を取得
        $rateInfos = $this->BasicRates->find('all', [
            'conditions' => ['AND' => [['is_deleted' => 0], ['start_date <=' => Time::now()]]],
            'order' => ['basic_rate' => 'DESC']
        ])
            ->select(['ticket_type', 'basic_rate'])
            ->all();


        // Discount_typesテーブルから料金と割引詳細を取得
        $discountInfos = $this->DiscountTypes->find('all', [
            'conditions' => ['AND' => [['is_deleted' => 0], ['start_date <=' => Time::now()]]]
        ])
            ->select(['discount_type', 'discount_details', 'discount_price'])
            ->all();

        $this->set(compact('rateInfos'));
        $this->set(compact('discountInfos'));

        // ログイン中はマイページを右上に表示
        $this->viewBuilder()->setLayout('toppage');
    }


    //ログアウト状態でも閲覧可能
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'price']);
    }
}
