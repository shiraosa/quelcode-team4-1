<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Points Controller
 *
 * @property \App\Model\Table\PointsTable $Points
 *
 * @method \App\Model\Entity\Point[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PointsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Payments', 'Users'],
        ];
        $points = $this->paginate($this->Points);

        $this->set(compact('points'));
    }

    /**
     * View method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $point = $this->Points->get($id, [
            'contain' => ['Payments', 'Users'],
        ]);

        $this->set('point', $point);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $point = $this->Points->newEntity();
        if ($this->request->is('post')) {
            $point = $this->Points->patchEntity($point, $this->request->getData());
            if ($this->Points->save($point)) {
                $this->Flash->success(__('The point has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The point could not be saved. Please, try again.'));
        }
        $payments = $this->Points->Payments->find('list', ['limit' => 200]);
        $users = $this->Points->Users->find('list', ['limit' => 200]);
        $this->set(compact('point', 'payments', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $point = $this->Points->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $point = $this->Points->patchEntity($point, $this->request->getData());
            if ($this->Points->save($point)) {
                $this->Flash->success(__('The point has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The point could not be saved. Please, try again.'));
        }
        $payments = $this->Points->Payments->find('list', ['limit' => 200]);
        $users = $this->Points->Users->find('list', ['limit' => 200]);
        $this->set(compact('point', 'payments', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Point id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $point = $this->Points->get($id);
        if ($this->Points->delete($point)) {
            $this->Flash->success(__('The point has been deleted.'));
        } else {
            $this->Flash->error(__('The point could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
