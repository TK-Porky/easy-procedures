<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Users Controller (Admin Prefix)
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $usertable = $this->fetchTable('Users');
        $users = $usertable->find()
            ->where(['id_role' => 2, 'deleted' => false])
            ->all();
        $this->set(compact('users'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $userstable = $this->fetchTable('Users');
        $user = $userstable->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $userstable->patchEntity($user, $this->request->getData());
            $existingUserCount = $userstable->countUsersWithEmail($user->email);

            if ($existingUserCount > 0) {
                $this->Flash->error('This email is already taken.');
                return;
            } else {
                $user->id_role = 2; // Agent
                $user->deleted = 0;
                if ($userstable->save($user)) {
                    $this->Flash->success('L\'agent a été créé avec succès.');
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error('Erreur lors de la création de l\'agent.');
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->find('all', [
            'conditions' => ['id' => $id, 'deleted' => false],
        ])->first();

        if (empty($user)) {
            $this->Flash->error("Utilisateur introuvable.");
            return $this->redirect($this->referer());
        }

        $user->set('deleted', true);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('L\'utilisateur a été supprimé.'));
        } else {
            $this->Flash->error(__('L\'utilisateur n\'a pas pu être supprimé.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('L\'utilisateur a été modifié.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erreur lors de la modification.'));
        }
        $this->set(compact('user'));
    }
}
