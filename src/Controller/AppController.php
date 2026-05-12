<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Authentication\AuthenticationServiceInterface;
use Cake\View\Helper\FormHelper;




/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
       


        /** $this->Auth->allow(['home', 'display', 'login']);
         * $this->Auth->allow(['view', 'index']);
         * $this->Auth->allow(['view', 'edit']);
         *$this->Auth->allow(['view', 'add']);
         *$this->Auth->allow(['view', 'view']);
         */


        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        $this->loadComponent('FormProtection');
    }

    public function getAuthenticatedUser()
    {
        if (!isset($this->Authentication)) {
            return null;
        }
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            return $result->getData();
        }
        return null;
    }

 

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $prefix = $this->request->getParam('prefix');
        $user = $this->getAuthenticatedUser();

        // Si l'utilisateur est connecté mais accède à une route sans préfixe (racine)
        if (!$prefix && $user) {
            $roleId = (int)$user->id_role;
            $action = $this->request->getParam('action');
            $controller = $this->request->getParam('controller');

            // Whitelist des actions et contrôleurs autorisés à la racine pour les connectés
            // On exclut 'display' (la vitrine) de la whitelist pour forcer la redirection vers le dashboard
            $whitelistedActions = ['logout', 'verify', 'resetPassword'];
            $whitelistedControllers = [
                'Auth', 
                'Procedurerequirements', 
                'Requirementproprieties',
                'Requestrequirements'
            ];

            if (!in_array($action, $whitelistedActions) && !in_array($controller, $whitelistedControllers)) {
                if ($roleId === 3) {
                    return $this->redirect(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']);
                } elseif ($roleId === 2) {
                    return $this->redirect(['prefix' => 'Agent', 'controller' => 'Dashboard', 'action' => 'index']);
                } elseif ($roleId === 1) {
                    return $this->redirect(['prefix' => 'Client', 'controller' => 'Dashboard', 'action' => 'index']);
                }
            }
        }

        // Vérification des autorisations par préfixe
        $action = $this->request->getParam('action');

        // Si l'utilisateur est déjà connecté et tente d'accéder à une page de login
        if ($user && $action === 'login') {
            $roleId = (int)$user->id_role;
            if ($roleId === 3) {
                return $this->redirect(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']);
            } elseif ($roleId === 2) {
                return $this->redirect(['prefix' => 'Agent', 'controller' => 'Dashboard', 'action' => 'index']);
            } elseif ($roleId === 1) {
                return $this->redirect(['prefix' => 'Client', 'controller' => 'Dashboard', 'action' => 'index']);
            }
        }

        if ($prefix && $user && $action !== 'logout') {
            $roleId = (int)$user->id_role;
            $isAuthorized = false;

            if (strtolower($prefix) === 'admin' && $roleId === 3) {
                $isAuthorized = true;
            } elseif (strtolower($prefix) === 'agent' && $roleId === 2) {
                $isAuthorized = true;
            } elseif (strtolower($prefix) === 'client' && $roleId === 1) {
                $isAuthorized = true;
            } elseif (strtolower($prefix) === 'api/v1') {
                $isAuthorized = true;
            }

            if (!$isAuthorized) {
                $this->Flash->error(__('Accès non autorisé.'));
                return $this->redirect('/');
            }
        }
    }

    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        parent::beforeRender($event);
        
        $user = $this->getAuthenticatedUser();
        if ($user) {
            $userstable = $this->fetchTable('Users');
            try {
                $userData = $userstable->get($user->id);
                $this->set('user', $userData);
            } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
                // User in session but not in DB
                $this->set('user', null);
            }
        } else {
            $this->set('user', null);
        }
    }
}
