<?php

declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Laminas\Diactoros\UploadedFile;

/**
 * Requests Controller (Client Prefix)
 *
 * @property \App\Model\Table\RequestsTable $Requests
 */
class RequestsController extends AppController
{
    public function index()
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $this->paginate = [
            'contain' => ['Procedures'],
            'conditions' => ['user_id' => $userId, 'Requests.deleted' => false]
        ];
        $requests = $this->paginate($this->Requests);

        $this->set(compact('requests'));
    }

    public function add($id)
    {
        $procedureTable = $this->getTableLocator()->get('Procedures');
        $procedure = $procedureTable->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false]
        ])->first();

        if (empty($procedure)) {
            $this->Flash->error("Procedure not found");
            return $this->redirect($this->referer());
        }

        $request = $this->Requests->newEmptyEntity();

        if ($this->request->is('post')) {
            $userId = $this->Authentication->getIdentity()->getIdentifier();

            $request = $this->Requests->patchEntity($request, $this->request->getData());
            $request->user_id = $userId;
            $request->procedure_id = $id;

            $existingRequest = $this->Requests->find()
                ->where(['user_id' => $userId, 'procedure_id' => $id])
                ->first();

            if ($existingRequest) {
                return $this->redirect([
                    'action' => 'requirementlist',
                    $existingRequest->id
                ]);
            } else {
                if ($this->Requests->save($request)) {
                    return $this->redirect([
                        'action' => 'requirementlist',
                        $request->id
                    ]);
                }
            }

            $this->Flash->error(__('Try again'));
        }

        $this->set(compact('request', 'procedure'));
    }

    public function firstview($request_id)
    {
        $request = $this->Requests->get($request_id, [
            'conditions' => ['Requests.deleted' => false],
            'contain' => ['Users', 'Procedures', 'Requestrequirements' => ['Requestrequirementproprieties' => ['Requirementproprieties'], 'Procedurerequirements' => ['Requirements']]],
        ]);

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect($this->referer());
        }

        $procedurerequirements = $this->Requests->Procedures->Procedurerequirements->find('all', [
            'conditions' => [
                'Procedurerequirements.procedure_id' => $request->procedure_id
            ],
            'contain' => ['Requirements'],
        ])->all();

        $this->set(compact('procedurerequirements', 'request'));
    }

    public function requirementlist($request_id)
    {
        $request = $this->Requests->find('all', [
            'conditions' => ['Requests.id' => $request_id, 'Requests.deleted' => false],
            'contain' => ['Requestrequirements', 'Procedures'],
        ])->first();

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect($this->referer());
        }

        $procedurerequirements = $this->Requests->Procedures->Procedurerequirements->find('all', [
            'conditions' => [
                'Procedurerequirements.procedure_id' => $request->procedure_id
            ],
            'contain' => ['Requirements'],
        ])->all();

        $this->set(compact('procedurerequirements', 'request'));
    }

    public function fill($procedure_req_id, $request_id)
    {
        $authUser = $this->getAuthenticatedUser();

        $procedureRequirement = $this->Requests->Procedures->Procedurerequirements->get($procedure_req_id, [
            'contain' => ['Requirements' => ['Requirementproprieties', 'Requirementtypes'], 'Procedures']
        ]);

        if (empty($procedureRequirement)) {
            $this->Flash->error("Can not find procedure requirement.");
            return $this->redirect($this->referer());
        }

        $request = $this->Requests->find('all', ['conditions' => [
            'id' => $request_id, 'deleted' => false
        ]])->first();

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect($this->referer());
        }

        $requestRequirement = $this->Requests->Requestrequirements->find('all', [
            'conditions' => ['request_id' => $request_id, 'procedurerequirement_id' => $procedure_req_id],
            'contain' => ['Requestrequirementproprieties']
        ])->first();

        $requirement = $procedureRequirement->requirement;
        $requirementproprieties = $requirement->requirementproprieties;

        if ($authUser && $authUser->id != $request->user_id) {
            $this->Flash->error("you have not acces in this page.");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            if ($requirement->requirementtype_id == 3) {
                $requestRequirement = $requestRequirement ?? $this->Requests->Requestrequirements->newEmptyEntity();
                $requestRequirement->set('procedurerequirement_id', $procedureRequirement->get('id'));
                $requestRequirement->set('request_id', $request->get('id'));
                $requestRequirement->set('status', 'pending');

                if ($requestRequirement = $this->Requests->Requestrequirements->save($requestRequirement)) {
                    $requirementPropertiesTable = TableRegistry::getTableLocator()->get('Requestrequirementproprieties');

                    $fieldsErrors = [];

                    foreach ($requirementproprieties as $property) {
                        $propertyField = array_filter(
                            array_keys($this->request->getData()),
                            fn ($field) => $field == $property->name
                        );

                        if (empty($propertyField)) {
                            $fieldsErrors[$property->name] = 'Veuillez remplir le champs';
                        } else {
                            $requestRequirementProperty = $requirementPropertiesTable->find('all', [
                                'conditions' => [
                                    'requirementpropriety_id' => $property->id,
                                    'requestrequirement_id' => $requestRequirement->id
                                ]
                            ])->first();

                            if (empty($requestRequirementProperty)) {
                                $requestRequirementProperty =  $requirementPropertiesTable->newEmptyEntity();
                            }

                            $requestRequirementProperty->set('requirementpropriety_id', $property->id);
                            $requestRequirementProperty->set('requestrequirement_id', $requestRequirement->id);
                            $requestRequirementProperty->set('value', $this->request->getData($property->name, $property->default_value));
                            $requestRequirementProperty->set('deleted', false);

                            if (!$requirementPropertiesTable->save($requestRequirementProperty)) {
                                $this->Flash->error(' not save');
                                return $this->redirect($this->referer());
                            }
                        }
                    }

                    if (empty($fieldsErrors)) {
                        $this->Flash->success('Requirement filled successfully !');
                        return $this->redirect([
                            'action' => 'requirementlist',
                            $request_id
                        ]);
                    } else {
                        $this->Flash->error('Failed to achieve the operation');
                        $this->set(compact('fieldsErrors'));
                    }
                }
            } else if ($requirement->requirementtype_id == 4) {
                $requestRequirement = $this->Requests->Requestrequirements->newEmptyEntity();

                $uploadUrl = $this->uploadRequirement($this->request->getData('file'));
                $requestRequirement->set('procedurerequirement_id', $procedureRequirement->get('id'));
                $requestRequirement->set('request_id', $request->get('id'));
                $requestRequirement->set('status', 'pending');
                $requestRequirement->set('value', $uploadUrl);

                if ($this->Requests->Requestrequirements->save($requestRequirement)) {
                    $this->Flash->success('image upload sucess');
                } else {
                    $this->Flash->error('upload error');
                }
                
                return $this->redirect([
                    'action' => 'requirementlist',
                    $request->id
                ]);
            }
        }

        $this->set(compact(
            'procedureRequirement',
            'request',
            'requirement',
            'requirementproprieties',
            'requestRequirement'
        ));
    }

    private function uploadRequirement($file): string
    {
        if ($file instanceof UploadedFile && $file->getError() === UPLOAD_ERR_OK) {
            $destinationDirectory = WWW_ROOT . 'template' . DS . 'images' . DS;
            $safeFilename = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientFilename());
            $filename = time() . '_' . $safeFilename;
            $destinationPath = $destinationDirectory . $filename;

            try {
                $file->moveTo($destinationPath);
                return $filename;
            } catch (\Exception $e) {
                return '';
            }
        }
        return '';
    }
}
