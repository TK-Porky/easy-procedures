<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class AuthController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function beforeRender($Event)
    {
        $this->viewBuilder()->setLayout('auth_layout');
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                $user = $result->getData();
                if ((int)$user->id_role !== 3) {
                    $this->Authentication->logout();
                    $this->Flash->error(__('Accès non autorisé pour ce portail. Veuillez utiliser le portail approprié.'));
                    return $this->redirect(['action' => 'login']);
                }
                
                $target = $this->request->getQuery('redirect', ['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']);
                return $this->redirect($target);
            } else {
                $this->Flash->error(__('Identifiant ou mot de passe invalide'));
            }
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['prefix' => 'Admin', 'controller' => 'Auth', 'action' => 'login']);
    }
}
