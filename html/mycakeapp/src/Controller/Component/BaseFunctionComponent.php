<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class BaseFunctionComponent extends Component
{
    /**
     * Undocumented function
     * 一連の予約処理で使われる各セッションの削除
     *
     * @param [type] $session $this->request->getSession()したものを引数とする
     * @return void なし
     */
    public function deleteSessionReservation($session)
    {
        $session->delete('schedule');
        $session->delete('profile');
        $session->delete('discountTypeId');
        $session->delete('price');
        $session->delete('creditcard');
        $session->delete('usePoint');
        $session->delete('totalPayment');

        // 座席テーブルに削除フラグを立てる
        if (($session->check('seat_id')) && (($session->read('completed') === null))) {
            $seatsTable = TableRegistry::getTableLocator()->get('Seats');
            $seat = $seatsTable->get($session->read('seat_id'));
            $seat->is_deleted = 1;
            $seatsTable->save($seat);

            $session->delete('completed');
            $session->delete('seat_id');
        }
    }

    /**
     * Undocumented function
     * 認証ユーザーの使用可能なクレジットカード情報を検索します
     *
     * @param [type] $userId 認証ユーザーIDを引数とする
     * @return void 使用可能なクレジットカード情報 || null
     */
    public function aliveCreditcard($userId) {
        $creditcards = TableRegistry::getTableLocator()->get('Creditcards');
        $aliveCredit = $creditcards->find('all', [
            'conditions' => ['AND' => [['user_id' => $userId], ['is_deleted' => 0], ['expiration_date >=' => Time::now()->year . '-' . Time::now()->month . '-1']]]
        ])->first();
        return $aliveCredit;
    }
}
