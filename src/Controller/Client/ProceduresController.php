<?php
declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\AppController;

/**
 * Procedures Controller (Client Prefix)
 *
 * @property \App\Model\Table\ProceduresTable $Procedures
 */
class ProceduresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'conditions' => ['deleted' => false]
        ];
        $procedures = $this->paginate($this->Procedures);

        $this->set(compact('procedures'));
    }

    /**
     * Details method
     *
     * @param string|null $id Procedure id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function details($id)
    {
        $procedure = $this->Procedures->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();

        if (empty($procedure)) {
            $this->Flash->error("Procedure not found");
            return $this->redirect($this->referer());
        }

        $this->set(compact('procedure'));
    }
}
