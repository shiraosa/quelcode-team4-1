<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DiscountLogs Controller
 *
 * @property \App\Model\Table\DiscountLogsTable $DiscountLogs
 *
 * @method \App\Model\Entity\DiscountLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiscountLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['DiscountTypes', 'Reservations'],
        ];
        $discountLogs = $this->paginate($this->DiscountLogs);

        $this->set(compact('discountLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Discount Log id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discountLog = $this->DiscountLogs->get($id, [
            'contain' => ['DiscountTypes', 'Reservations'],
        ]);

        $this->set('discountLog', $discountLog);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $discountLog = $this->DiscountLogs->newEntity();
        if ($this->request->is('post')) {
            $discountLog = $this->DiscountLogs->patchEntity($discountLog, $this->request->getData());
            if ($this->DiscountLogs->save($discountLog)) {
                $this->Flash->success(__('The discount log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount log could not be saved. Please, try again.'));
        }
        $discountTypes = $this->DiscountLogs->DiscountTypes->find('list', ['limit' => 200]);
        $reservations = $this->DiscountLogs->Reservations->find('list', ['limit' => 200]);
        $this->set(compact('discountLog', 'discountTypes', 'reservations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Discount Log id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $discountLog = $this->DiscountLogs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discountLog = $this->DiscountLogs->patchEntity($discountLog, $this->request->getData());
            if ($this->DiscountLogs->save($discountLog)) {
                $this->Flash->success(__('The discount log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount log could not be saved. Please, try again.'));
        }
        $discountTypes = $this->DiscountLogs->DiscountTypes->find('list', ['limit' => 200]);
        $reservations = $this->DiscountLogs->Reservations->find('list', ['limit' => 200]);
        $this->set(compact('discountLog', 'discountTypes', 'reservations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Discount Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discountLog = $this->DiscountLogs->get($id);
        if ($this->DiscountLogs->delete($discountLog)) {
            $this->Flash->success(__('The discount log has been deleted.'));
        } else {
            $this->Flash->error(__('The discount log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
