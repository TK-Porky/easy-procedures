<?php
declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\AppController;
use Cake\Mailer\Mailer;

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
        $this->Authentication->allowUnauthenticated(['login', 'register', 'forgetpassword', 'verify']);
    }

    public function beforeRender($Event)
    {
        $this->viewBuilder()->setLayout('auth_layout');
    }

    private function generateVerificationToken()
    {
        $length = 32;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = mt_rand(0, strlen($characters) - 1);
            $token .= $characters[$randomIndex];
        }
        return $token;
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                $user = $result->getData();
                if ((int)$user->id_role !== 1) {
                    $this->Authentication->logout();
                    $this->Flash->error(__('Accès non autorisé pour ce portail. Veuillez utiliser le portail approprié.'));
                    return $this->redirect(['action' => 'login']);
                }
                
                $target = $this->request->getQuery('redirect', ['prefix' => 'Client', 'controller' => 'Dashboard', 'action' => 'index']);
                return $this->redirect($target);
            } else {
                $this->Flash->error(__('Identifiant ou mot de passe invalide'));
            }
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'login']);
    }

    public function register()
    {
        $usersTable = $this->getTableLocator()->get('Users');
        $user = $usersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $usersTable->patchEntity($user, $this->request->getData());
            $existingUserCount = $usersTable->find()->where(['email' => $user->email])->count();

            if ($existingUserCount > 0) {
                $this->Flash->error(__('Cet email est déjà utilisé.'));
            } else {
                if ($this->request->getData('password') !== $this->request->getData('confirm-password')) {
                    $this->Flash->error(__('Les mots de passe ne correspondent pas.'));
                } else {
                    $user->id_role = 1;
                    $user->deleted = 0;
                    $user->phonenumber = $user->phonenumber ?? 0;
                    $user->token = $this->generateVerificationToken();

                    if ($usersTable->save($user)) {
                        $mailer = new Mailer('default');
                        $mailer->setTo($user->email)
                            ->setSubject('Confirmez votre email')
                            ->deliver('Cliquez sur le lien suivant pour vérifier votre email : ' . $this->generateVerificationLink($user->token));

                        $this->Flash->success(__('Un lien de vérification a été envoyé à votre adresse email.'));
                        return $this->redirect(['action' => 'login']);
                    } else {
                        $this->Flash->error(__('Une erreur s\'est produite lors de l\'enregistrement de votre compte.'));
                    }
                }
            }
        }
        $this->set(compact('user'));
    }

    private function generateVerificationLink($verificationToken)
    {
        // On utilise Router::url pour plus de flexibilité
        return \Cake\Routing\Router::url(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'verify', $verificationToken], true);
    }

    public function verify($verificationToken)
    {
        $usersTable = $this->getTableLocator()->get('Users');
        $user = $usersTable->find()->where(['token' => $verificationToken])->first();

        if ($user) {
            $user->Verifications = 1;
            $user->token = null;

            if ($usersTable->save($user)) {
                $this->Flash->success(__('Votre compte a été vérifié. Vous pouvez maintenant vous connecter.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Une erreur est survenue lors de la vérification.'));
            }
        } else {
            $this->Flash->error(__('Lien de vérification invalide.'));
        }
        return $this->redirect(['action' => 'login']);
    }

    public function forgetpassword()
    {
        $userstable = $this->fetchTable('Users');
        if ($this->request->is('post')) {
            $user = $userstable->findByEmail($this->request->getData('email'))->first();
            if ($user) {
                $token = $this->generateVerificationToken();
                $user->reset_password_token = $token;
                $userstable->save($user);

                $mailer = new Mailer('default');
                $mailer->setTo($user->email)
                    ->setSubject('Réinitialisation de mot de passe')
                    ->deliver('Cliquez sur le lien suivant pour réinitialiser votre mot de passe : ' . \Cake\Routing\Router::url(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'resetPassword', $token], true));

                $this->Flash->success(__('Un email de réinitialisation a été envoyé.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Adresse email invalide.'));
            }
        }
    }
}
