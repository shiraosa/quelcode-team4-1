<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\Utility\Security;

class PaymentRegistrationController extends AppController
{
    public function initialize()
    {
        // baseControllerで読み込んでたら削除
        parent::initialize();
        $this->loadModel('Creditcards');
    }

    public function index()
    {

    }

    public function add()
    {
        
    }
}
