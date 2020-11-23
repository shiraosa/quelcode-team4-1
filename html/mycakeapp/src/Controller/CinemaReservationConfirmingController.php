<?php

namespace App\Controller;

use Cake\Validation\Validator;

class CinemaReservationConfirmingController extends CinemaBaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('BasicRates');
        $this->loadModel('Schedules');
        $this->viewBuilder()->setLayout('quel_cinemas');
        $this->loadComponent('Days');
    }

    public function index()
    {
        // * プレビュー用の暫定的なParameter
        $scheduleId = 19; // GoPro
        $seatNo = 'A-1';
        // * ここまで

        if (empty($scheduleId) || empty($seatNo)) {
            return $this->redirect(['controller' => 'CinemaSchedules', 'action' => 'index']);
        }

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
        $schedule = $session->read('schedule');

        $this->set(compact('schedule'));
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
