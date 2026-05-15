<?php

declare(strict_types=1);

namespace App\Controller;

use PHPUnit\Framework\Constraint\Count;

/**
 * Procedurerequirements Controller
 *
 * @property \App\Model\Table\ProcedurerequirementsTable $Procedurerequirements
 * @method \App\Model\Entity\Procedurerequirement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProcedurerequirementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id)
    {
        $procedure = $this->Procedurerequirements->Procedures->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();
        if (empty($procedure)) {
            $this->Flash->error("Procédure introuvable.");
            $this->redirect($this->referer());
        }
        $this->paginate = [
            'contain' => ['Requirements'],
            'conditions' => ['procedure_id' => $id, 'Requirements.deleted' => false],

        ];
        $procedurerequirements = $this->paginate($this->Procedurerequirements);
        $this->add($id);
        $this->set(compact('procedurerequirements', 'procedure'));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id)
    {
        $procedure = $this->Procedurerequirements->Procedures->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();

        $procedurerequirement = $this->Procedurerequirements->newEmptyEntity();
        if ($this->request->is('post')) {

            $i = 0;
            foreach ($this->request->getData('requirement_id') as $requirement_id) {
                $procedurerequirement = $this->Procedurerequirements->newEmptyEntity();
                $procedurerequirement->set('requirement_id', $requirement_id);
                $procedurerequirement->set('procedure_id', $id);

                $checkrequirement = $this->Procedurerequirements->find('all', [
                    'conditions' => ['procedure_id' => $id, 'requirement_id' => $requirement_id]
                ])->first();

                if (empty($checkrequirement)) {
                    if ($this->Procedurerequirements->save($procedurerequirement)) {
                        $i++;
                    }
                } else {
                    $checkrequirement->set('deleted', false);
                    if ($this->Procedurerequirements->save($checkrequirement)) {
                        $i++;
                    }
                }
            }

            if ($i === count($this->request->getData('requirement_id'))) {
                $this->Flash->success(__('Le pré-requis de la procédure a été enregistré.'));

                return $this->redirect(['action' => 'index', $procedurerequirement->procedure_id]);
            } else {

                $this->Flash->error(__('Le pré-requis de la procédure n\'a pas pu être enregistré. Veuillez réessayer.'));
            }
        }

        $requirements = $this->Procedurerequirements->Requirements->find('list', [])->all();
        $this->set(compact('procedurerequirement', 'procedure', 'requirements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Procedurerequirement id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $procedurerequirement = $this->Procedurerequirements->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();
        if (empty($procedurerequirement)) {
            $this->Flash->error("Pré-requis de procédure introuvable.");
            $this->redirect($this->referer());
        }
        $procedurerequirement->set('deleted', true);

        if ($this->Procedurerequirements->save($procedurerequirement)) {
            $this->Flash->success(__('Le pré-requis de la procédure a été supprimé.'));
        } else {
            $this->Flash->error(__('Le pré-requis de la procédure n\'a pas pu être supprimé. Veuillez réessayer.'));
        }

        return $this->redirect(['action' => 'index', $procedurerequirement->procedure_id]);
    }
    public function details($id)
    {
        $procedure = $this->Procedurerequirements->Procedures->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();
        if (empty($procedure)) {
            $this->Flash->error("Procédure introuvable.");
            $this->redirect($this->referer());
        }
        $this->paginate = [
            'contain' => ['Requirements'],
            'conditions' => ['procedure_id' => $id, 'requirements.deleted' => false],

        ];

        $procedurerequirements = $this->paginate($this->Procedurerequirements);

        $this->set(compact('procedurerequirements', 'procedure'));
    }
    
}
