<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Procedures Controller (Admin Prefix)
 *
 * @property \App\Model\Table\ProceduresTable $Procedures
 */
class ProceduresController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'conditions' => ['deleted' => false]
        ];
        $procedures = $this->paginate($this->Procedures);
        $this->add();
        $this->set(compact('procedures'));
    }

    public function view($id = null)
    {
        $procedure = $this->Procedures->get($id, [
            'contain' => ['Procedurerequirements', 'Requests'],
        ]);

        $this->set(compact('procedure'));
    }

    public function add()
    {
        $procedure = $this->Procedures->newEmptyEntity();

        if ($this->request->is('post')) {
            $procedure = $this->Procedures->patchEntity($procedure, $this->request->getData());
            $procedure->deleted = 0;
            if ($this->Procedures->save($procedure)) {
                $this->Flash->success(__('The procedure has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The procedure could not be saved. Please, try again.'));
        }
        $this->set(compact('procedure'));
    }

    public function edit($id = null)
    {
        $procedure = $this->Procedures->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $procedure = $this->Procedures->patchEntity($procedure, $this->request->getData());
            if ($this->Procedures->save($procedure)) {
                $this->Flash->success(__('The procedure has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The procedure could not be saved. Please, try again.'));
        }
        $this->set(compact('procedure'));
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $procedure = $this->Procedures->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();
        if (empty($procedure)) {
            $this->Flash->error("procedure not found");
            $this->redirect($this->referer());
        }
        $procedure->set('deleted', true);
        if ($this->Procedures->save($procedure)) {
            $this->Flash->success(__('The procedure has been deleted.'));
        } else {
            $this->Flash->error(__('The procedure could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
