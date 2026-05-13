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
            'conditions' => ['user_id' => $userId, 'Requests.deleted' => 0]
        ];
        $requests = $this->paginate($this->Requests);

        $this->set(compact('requests'));
    }

    public function add($id)
    {
        $procedureTable = $this->getTableLocator()->get('Procedures');
        $procedure = $procedureTable->find('all', [
            'conditions' => ['id' => $id, 'deleted' => 0]
        ])->first();

        if (empty($procedure)) {
            $this->Flash->error("Procedure not found");
            return $this->redirect($this->referer());
        }

        $request = $this->Requests->newEmptyEntity();

        if ($this->request->is('post')) {
            $userId = $this->Authentication->getIdentity()->getIdentifier();

            $existingRequest = $this->Requests->find()
                ->where(['user_id' => $userId, 'procedure_id' => $id, 'deleted' => 0])
                ->first();

            if ($existingRequest) {
                return $this->redirect([
                    'action' => 'requirementlist',
                    $existingRequest->id
                ]);
            } else {
                $request = $this->Requests->patchEntity($request, $this->request->getData());
                $request->user_id = $userId;
                $request->procedure_id = $id;
                $request->status = 'Draft';
                $request->deleted = 0;

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
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $request = $this->Requests->find('all', [
            'conditions' => [
                'Requests.id' => $request_id,
                'Requests.user_id' => $userId,
                'Requests.deleted' => 0
            ],
            'contain' => ['Users', 'Procedures', 'Requestrequirements' => ['Requestrequirementproprieties' => ['Requirementproprieties'], 'Procedurerequirements' => ['Requirements']]],
        ])->first();

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect(['action' => 'index']);
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
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $request = $this->Requests->find('all', [
            'conditions' => [
                'Requests.id' => $request_id,
                'Requests.user_id' => $userId,
                'Requests.deleted' => 0
            ],
            'contain' => ['Requestrequirements', 'Procedures'],
        ])->first();

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect(['action' => 'index']);
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
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $procedureRequirement = $this->Requests->Procedures->Procedurerequirements->get($procedure_req_id, [
            'contain' => ['Requirements' => ['Requirementproprieties', 'Requirementtypes'], 'Procedures']
        ]);

        if (empty($procedureRequirement)) {
            $this->Flash->error("Can not find procedure requirement.");
            return $this->redirect($this->referer());
        }

        $request = $this->Requests->find('all', [
            'conditions' => [
                'Requests.id' => $request_id,
                'Requests.user_id' => $userId,
                'Requests.deleted' => 0
            ]
        ])->first();

        if (empty($request)) {
            $this->Flash->error("Can not load request.");
            return $this->redirect(['action' => 'index']);
        }

        $requestRequirement = $this->Requests->Requestrequirements->find('all', [
            'conditions' => ['request_id' => $request_id, 'procedurerequirement_id' => $procedure_req_id],
            'contain' => ['Requestrequirementproprieties']
        ])->first();

        $requirement = $procedureRequirement->requirement;
        $requirementproprieties = $requirement->requirementproprieties;

        if ($this->request->is('post')) {
            if ($requirement->requirementtype->type == 'formulaire') {
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
            } else if ($requirement->requirementtype->type == 'file') {
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

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        
        $request = $this->Requests->find()
            ->where(['id' => $id, 'user_id' => $userId])
            ->first();

        if (empty($request)) {
            $this->Flash->error("Request not found or you don't have access.");
            return $this->redirect(['action' => 'index']);
        }

        $request->deleted = true;
        if ($this->Requests->save($request)) {
            $this->Flash->success(__('The request has been canceled.'));
        } else {
            $this->Flash->error(__('The request could not be canceled. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function requestapprobation($id)
    {
        $this->request->allowMethod(['post']);
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $request = $this->Requests->find()
            ->where(['Requests.id' => $id, 'user_id' => $userId])
            ->contain(['Procedures' => ['Procedurerequirements'], 'Requestrequirements'])
            ->first();

        if (empty($request)) {
            $this->Flash->error("Request not found.");
            return $this->redirect(['action' => 'index']);
        }

        $procedureRequirements = $request->procedure->procedurerequirements;
        $requirementStatus = true;

        foreach ($procedureRequirements as $procedureRequirement) {
            $matchingRequirement = array_filter($request->requestrequirements, function ($rr) use ($procedureRequirement) {
                return $rr->procedurerequirement_id == $procedureRequirement->id;
            });

            $matchingRequirement = count($matchingRequirement) > 0 ? reset($matchingRequirement) : null;

            if (!$matchingRequirement || !in_array($matchingRequirement->status, ['pending', 'success'])) {
                $requirementStatus = false;
                break;
            }
        }

        if ($requirementStatus) {
            $request->status = 'pending';
            if ($this->Requests->save($request)) {
                $this->Flash->success('Votre demande a été soumise pour validation.');
            } else {
                $this->Flash->error('Une erreur s\'est produite lors de la soumission.');
            }
        } else {
            $this->Flash->error('Veuillez remplir tous les pré-requis avant de soumettre.');
        }

        return $this->redirect(['action' => 'requirementlist', $request->id]);
    }

    public function cancelapprobation($id)
    {
        $this->request->allowMethod(['post']);
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $request = $this->Requests->get($id);

        if (empty($request) || $request->user_id != $userId) {
            $this->Flash->error("Request not found.");
            return $this->redirect(['action' => 'index']);
        }

        $request->status = 'Draft';

        if ($this->Requests->save($request)) {
            $this->Flash->success('Soumission annulée.');
        } else {
            $this->Flash->error('Une erreur s\'est produite lors de la mise à jour du statut.');
        }
        return $this->redirect(['action' => 'requirementlist', $request->id]);
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
