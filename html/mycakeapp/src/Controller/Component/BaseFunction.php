<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class BaseFunction extends Component
{
    public function destroySessionReservation($session)
    {
        if ($session->check('schedule')) {
            $session->delete('schedule');
        }
        if ($session->check('profile')) {
            $session->delete('profile');
        }
        if ($session->check('discountTypeId')) {
            $session->delete('discountTypeId');
        }
        if ($session->check('usePoint')) {
            $session->delete('usePoint');
        }
        if ($session->check('totalPayment')) {
            $session->delete('totalPayment');
        }

        // 座席テーブルに削除フラグを立てる
        $seatsTable = TableRegistry::getTableLocator()->get('Seat');
        $seat = $seatsTable->get($session->read('seatId'));
        $seat->is_deleted = 1;
        $seatsTable->save($seat);
    }
}
