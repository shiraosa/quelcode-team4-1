<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ToppageController extends AppController
{
    public function index()
    {
        $schedulesTable = TableRegistry::getTableLocator()->get('Schedules');

        // 上映映画画像をDBより取得
        $moviesTable = TableRegistry::getTableLocator()->get('Movies');
        $today = date('Y-m-d');
        $screeningMovies = $moviesTable
            ->find()
            ->select(['screening_img_path'])
            ->where([
                'OR' => [['end_date IS' => NULL],['end_date >=' => $today]]
            ]);
        $y = 0;
        foreach ($screeningMovies as $mvImg) {
            $screenings[$y] = $mvImg->screening_img_path;
            $y++;
        }
        $this->set('screenings', $screenings);

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
