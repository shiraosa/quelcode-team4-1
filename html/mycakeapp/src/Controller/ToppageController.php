<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ToppageController extends AppController
{
    public function index()
    {

        // 上映映画画像をDBより取得
        $moviesTable = TableRegistry::getTableLocator()->get('Movies');
        $todayDate = date('Y-m-d');
        $screeningMovies = $moviesTable
            ->find()
            ->select(['screening_img_path'])
            ->where([
                'OR' => [['end_date IS' => NULL],['end_date >=' => $todayDate]]
            ]);
        $x = 0;
        foreach ($screeningMovies as $mvImg) {
            $screenings[$x] = $mvImg->screening_img_path;
            $x++;
        }
        $this->set('screenings', $screenings);

        // スライドショーに使う画像を今後のスケジュールで上演回数の多い順3つをDBより取得
        $schedulesTable = TableRegistry::getTableLocator()->get('Schedules');
        $todayDatetime = date('Y-m-d H:i:s');
        $top3MoviesIdDesc = $schedulesTable
            ->find()
            ->select(['cnt_movie_id' => $schedulesTable->find()->func()->count('movie_id'), 'movie_id'])
            ->where(['AND' => [['start_datetime >' => $todayDatetime], ['is_deleted' => 0]]])
            ->group('movie_id')
            ->order(['cnt_movie_id' => 'DESC'])
            ->limit(3);
        $y = 0;
        foreach ($top3MoviesIdDesc as $mvId) {
            $top3MoviesId[$y] = $mvId->movie_id;
            $y++;
        }
        $top3Slideshow = $moviesTable
            ->find()
            ->select(['slideshow_img_path'])
            ->where(['id IN' => $top3MoviesId]);
        $z = 0;
        foreach ($top3Slideshow as $slide) {
            $top3Slideshows[$z] = $slide->slideshow_img_path;
            $z++;
        }

        $this->set('slideshow', $top3Slideshows);

        // 割引バナーをDBより取得
        $discountTypesTable = TableRegistry::getTableLocator()->get('DiscountTypes')
            ->find()
            ->select(['banner_path'])
            ->where(['is_deleted' => 0]);

        $i = 1;
        foreach ($discountTypesTable as $discount) {
            $discountBanners[$i] = $discount->banner_path;
            $i++;
        }
        $this->set('banners', $discountBanners);

        // 使用レイアウト変更
        $this->viewBuilder()->setLayout('toppage');
    }

}
