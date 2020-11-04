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
        $moviesTable = TableRegistry::getTableLocator()->get('Movies');

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
