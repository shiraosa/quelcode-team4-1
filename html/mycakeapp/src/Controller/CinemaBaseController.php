<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;

class CinemaBaseController extends AppController
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        // レイアウトの変更.
        $this->viewBuilder()->setLayout('quel_cinemas');

        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth',
                    'fields' => [
                        'username' => 'mailaddress',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            'logoutAction' => [
                'controller' => 'Login',
                'action' => 'logout'
            ],
            'loginRedirect' => [
                'controller' => 'Mypage',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Toppage',
                'action' => 'index'
            ],
            'authorize' => ['Controller'],
            'authError' => 'ログインしてください。',
            'unauthorizedRedirect' => $this->referer()
        ]);
        $this->set('auth', $this->Auth->user());
    }

    public function logout()
    {
        // セッションを破棄
        $session = $this->getRequest()->getSession();
        $session->destroy();
        return $this->redirect($this->Auth->logout());
    }
    // 認証時のロールの処理
    public function isAuthorized($user = null)
    {
        return true;
    }
}
