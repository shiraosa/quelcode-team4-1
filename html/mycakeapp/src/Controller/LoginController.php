<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;

use Cake\Event\Event;
use Exception;

class LoginController extends CinemaBaseController
{
    public $useTable = false;

    public function initialize()
    {
        parent::initialize();

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
            //ログイン先をマイページに固定
            'loginRedirect' => [
                'controller' => 'Mypage',
                'action' => 'index'
            ],
            //ログアウト先をトップページに固定
            'logoutRedirect' => [
                'controller' => 'QuelCinemas',
                'action' => 'index',
            ],
            'authorize' => ['Controller'],
            'authError' => 'ログインしてください。',
            'unauthorizedRedirect' => $this->referer()
        ]);


        //未定義エラー対策
        $errorMailaddress = null;
        $errorPassword = null;
        $this->set(compact(
            'errorPassword',
            'errorMailaddress',
        ));
    }

    public function index()
    {
        // POST時の処理
        if ($this->request->isPost()) {
            $user = $this->Auth->identify();
            // Authのidentifyをユーザーに設定
            if (!empty($user)) {
                $this->Auth->setUser($user);
                // return $this->redirect($this->Auth->redirectUrl());
                return $this->redirect(['controller' => 'Mypage', 'action' => 'index']);
            }

            //リクエストを変数に格納
            $check = $this->request->getData();
            //入力されたメールアドレスがあるか確認
            $mailCheck = $this->Users->find('all', [
                'conditions' => ['mailaddress' => $check['mailaddress'], 'is_deleted' => 0]
            ])->first();

            //メールアドレスがあればパスワードが間違っていると表示、メールアドレスが無ければメールアドレスが間違っていると表示。
            if (!empty($mailCheck)) {
                $errorPassword = "パスワードが間違っているようです。";
                $errorMailaddress = null;
            } else {
                $errorPassword = null;
                $errorMailaddress = "メールアドレスが間違っているようです。";
            }
            $this->set(compact(
                'errorPassword',
                'errorMailaddress'
            ));
        }
    }

    //ログインなしで閲覧を許可
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index']);
    }

    // 認証時のロールの処理
    public function isAuthorized($user = null)
    {
        return true;
    }

    public function logout()
    {
        // セッションを破棄
        $session = $this->getRequest()->getSession();
        $session->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
