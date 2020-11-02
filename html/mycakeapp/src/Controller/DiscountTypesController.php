<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DiscountTypes Controller
 *
 * @property \App\Model\Table\DiscountTypesTable $DiscountTypes
 *
 * @method \App\Model\Entity\DiscountType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiscountTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $discountTypes = $this->paginate($this->DiscountTypes);

        $this->set(compact('discountTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Discount Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discountType = $this->DiscountTypes->get($id, [
            'contain' => ['DiscountLogs'],
        ]);

        $this->set('discountType', $discountType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $discountType = $this->DiscountTypes->newEntity();
        if ($this->request->is('post')) {
            $discountType = $this->DiscountTypes->patchEntity($discountType, $this->request->getData());
            if ($this->DiscountTypes->save($discountType)) {
                $this->Flash->success(__('The discount type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount type could not be saved. Please, try again.'));
        }
        $this->set(compact('discountType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Discount Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $discountType = $this->DiscountTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discountType = $this->DiscountTypes->patchEntity($discountType, $this->request->getData());
            if ($this->DiscountTypes->save($discountType)) {
                $this->Flash->success(__('The discount type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount type could not be saved. Please, try again.'));
        }
        $this->set(compact('discountType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Discount Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discountType = $this->DiscountTypes->get($id);
        if ($this->DiscountTypes->delete($discountType)) {
            $this->Flash->success(__('The discount type has been deleted.'));
        } else {
            $this->Flash->error(__('The discount type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
