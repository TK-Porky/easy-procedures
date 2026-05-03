<?php

declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
/**
 * Test Controller
 *
 * @method \App\Model\Entity\Test[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            $this->Flash->error('Vous devez être connecté pour accéder à cette page');
            return $this->redirect(['controller' => 'Auth', 'action' => 'login']);
        }

        $userstable = $this->fetchTable('Users');
        $userData = $userstable->get($user->id);
        $this->set('user', $userData);

        // Fetch Metrics for Clients
        if ($userData->id_role == 1) {
            $requestsTable = $this->fetchTable('Requests');
            
            $totalRequests = $requestsTable->find()
                ->where(['user_id' => $user->id, 'Requests.deleted' => false])
                ->count();

            $pendingRequests = $requestsTable->find()
                ->where(['user_id' => $user->id, 'status' => 'pending', 'Requests.deleted' => false])
                ->count();

            $approvedRequests = $requestsTable->find()
                ->where(['user_id' => $user->id, 'status' => 'success', 'Requests.deleted' => false])
                ->count();

            $recentRequests = $requestsTable->find()
                ->where(['user_id' => $user->id, 'Requests.deleted' => false])
                ->contain(['Procedures'])
                ->order(['Requests.modified' => 'DESC'])
                ->limit(5)
                ->all();

            $this->set(compact('totalRequests', 'pendingRequests', 'approvedRequests', 'recentRequests'));
        }
    }
    public function account()
    {
       
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get($userId);
        $this->set('user', $user);
    }
    public function count()
    {
         $Table= $this->fetchTable('Requests');
         
        $count = $Table->find(
        )->count();

        $this->set(compact($count));
    }
    
}

