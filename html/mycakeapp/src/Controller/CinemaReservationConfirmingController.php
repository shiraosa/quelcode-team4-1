<?php

namespace App\Controller;

use Cake\Validation\Validator;
use Cake\Chronos\Chronos;

class CinemaReservationConfirmingController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('BasicRates');
        $this->loadModel('Schedules');
        $this->loadModel('DiscountTypes');
        $this->viewBuilder()->setLayout('quel_cinemas');
        $this->loadComponent('Days');
    }

    public function index()
    {
        // Sessionから値を取得する. ない場合はスケジュールへリダイレクトする
        $session = $this->request->getSession();
        if (!($session->check('schedule'))) {
            return $this->redirect(['controller' => 'CinemaSchedules', 'action' => 'index']);
        }
        $schedule = $session->read('schedule');
        $scheduleId = $schedule['id'];
        $seatNo = $schedule['seatNo'];

        // scheduleにまとめる
        $schedule = $this->Schedules->get($scheduleId, ['contain' => ['Movies']]);
        $start = $schedule['start_datetime'];
        $schedule['start'] = $this->Days->__getDayOfTheWeek($start) . $start->format('H:i');
        $end = $schedule['end_datetime'];
        $schedule['end'] = $end->format('H:i');
        $schedule['seatNo'] = $seatNo;

        $type = $this->BasicRates->find('list', ['valueField' => 'ticket_type'])->toArray();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $errors = $this->__validateProfile($data);

            if (empty($errors)) {
                $session = $this->request->getSession();
                $session->write(['profile' => $data, 'schedule' => $schedule]);

                return $this->redirect(['action' => 'confirm']);
            }
            $this->set(compact('errors'));
        }

        $this->set(compact('schedule', 'type'));
    }

    public function confirm()
    {
        $session = $this->request->getSession();

        if (!($session->check('profile')) || !($session->check('schedule'))) {
            return $this->redirect(['controller' => 'CinemaSchedules', 'action' => 'index']);
        }

        $profile = $session->read('profile');
        $schedule = $session->read('schedule');

        // 基本料金を取得する
        $price = $this->BasicRates->get($profile['type'])['basic_rate'];

        // 割引種類を取得して計算する
        $day = $schedule['start_datetime'];
        $age = Chronos::createFromDate($profile['year'], $profile['month'], $profile['day'])->age;

        if ($day->day === 1) {
            $discountType = 'ファーストデイ割引';
            $discountTypeId = 3;
        } elseif ($day->isWednesday() && (($profile['sex'] === 'female') || ($age <= 15) || ($age >= 70))) {
            $discountType = '子供女性シニア割引';
            $discountTypeId = 2;
        } else {
            $discountType = null;
            $discountTypeId = null;
        }

        if (!is_null($discountTypeId)) {
            $price += $this->DiscountTypes->get($discountTypeId)['discount_price'];
        }

        // 決済方法へ遷移する
        if ($this->request->is('post')) {
            $session->write(['price' => $price]);

            // TODO:遷移先の変更
            return $this->redirect(['controller' => 'CinemaSchedules', 'action' => 'index']);
        }

        $price = '&yen;' . number_format($price);

        $this->set(compact('schedule', 'price', 'discountType'));
    }

    private function __validateProfile($data)
    {
        $validator = new Validator();

        $validator
            ->notEmpty('sex', '選択されていません');

        $validator
            ->notEmpty('type', '選択されていません');

        $validator
            ->notEmpty('year', '生年月日が入力されていません')
            ->add('year', 'isDigit', [
                'rule' => function ($y) {
                    if (ctype_digit($y)) {
                        return true;
                    }
                    return '半角数字で入力してください';
                },
                'last' => true
            ])
            ->range('year', [1000, 9999], '西暦の形式が正しくありません');

        $validator
            ->notEmpty('month', '生年月日が入力されていません')
            ->add('month', 'isDigit', [
                'rule' => function ($m, $context) {
                    $y = $context['data']['year'];

                    if (ctype_digit($y)) {
                        if (ctype_digit($m)) {
                            return true;
                        }
                        return '半角数字で入力してください';
                    } else {
                        return '';
                    }
                },
                'last' => true
            ])
            ->range('month', [1, 12], '月の形式が正しくありません');

        $validator
            ->notEmpty('day', '生年月日が入力されていません')
            ->add('day', [
                'isDigit' => [
                    'rule' => function ($d, $context) {
                        $y = $context['data']['year'];
                        $m = $context['data']['month'];

                        if (ctype_digit($y) && ctype_digit($m)) {
                            if (ctype_digit($d)) {
                                return true;
                            }
                            return '半角数字で入力してください';
                        } else {
                            return '';
                        }
                    },
                    'last' => true
                ],
                'isDay' =>
                [
                    'rule' => function ($d, $context) {
                        $y = $context['data']['year'];
                        $m = $context['data']['month'];

                        if (ctype_digit($y) && ctype_digit($m)) {
                            if (checkdate($m, $d, $y)) {
                                return true;
                            }
                        } else {
                            return '';
                        }
                        return '日の形式が正しくありません';
                    }
                ]
            ]);


        $errors = $validator->errors($data);

        return $errors;
    }
}
