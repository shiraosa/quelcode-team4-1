<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

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
    }
}
