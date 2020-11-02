<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BasicRates Controller
 *
 * @property \App\Model\Table\BasicRatesTable $BasicRates
 *
 * @method \App\Model\Entity\BasicRate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BasicRatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $basicRates = $this->paginate($this->BasicRates);

        $this->set(compact('basicRates'));
    }

    /**
     * View method
     *
     * @param string|null $id Basic Rate id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $basicRate = $this->BasicRates->get($id, [
            'contain' => ['Reservations'],
        ]);

        $this->set('basicRate', $basicRate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $basicRate = $this->BasicRates->newEntity();
        if ($this->request->is('post')) {
            $basicRate = $this->BasicRates->patchEntity($basicRate, $this->request->getData());
            if ($this->BasicRates->save($basicRate)) {
                $this->Flash->success(__('The basic rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The basic rate could not be saved. Please, try again.'));
        }
        $this->set(compact('basicRate'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Basic Rate id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $basicRate = $this->BasicRates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $basicRate = $this->BasicRates->patchEntity($basicRate, $this->request->getData());
            if ($this->BasicRates->save($basicRate)) {
                $this->Flash->success(__('The basic rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The basic rate could not be saved. Please, try again.'));
        }
        $this->set(compact('basicRate'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Basic Rate id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $basicRate = $this->BasicRates->get($id);
        if ($this->BasicRates->delete($basicRate)) {
            $this->Flash->success(__('The basic rate has been deleted.'));
        } else {
            $this->Flash->error(__('The basic rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
