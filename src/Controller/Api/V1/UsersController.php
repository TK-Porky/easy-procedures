<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Core\Configure;
use OpenApi\Annotations as OA;

/**
 * API Users Controller
 * 
 * @OA\Tag(name="Users", description="User authentication and management")
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Easy Procedures API",
 *         version="1.0.0",
 *         description="REST API for managing bank procedures and requests."
 *     ),
 *     @OA\Server(
 *         url="/api/v1",
 *         description="API V1 Server"
 *     )
 * )
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['login', 'register', 'forgetPassword']);
    }

    /**
     * Register method
     *
     * @OA\Post(
     *     path="/api/v1/users/register",
     *     tags={"Users"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","surname","email","phonenumber","password","confirm-password"},
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="surname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phonenumber", type="integer", example=123456789),
     *             @OA\Property(property="password", type="string", format="password", example="secret"),
     *             @OA\Property(property="confirm-password", type="string", format="password", example="secret")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Registration successful. Please verify your email.")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function register()
    {
        $this->request->allowMethod(['post']);
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->newEmptyEntity();
        
        $data = $this->request->getData();
        $user = $usersTable->patchEntity($user, $data);
        
        if ($usersTable->countUsersWithEmail($user->email) > 0) {
            $this->response = $this->response->withStatus(400);
            $json = ['status' => 'error', 'message' => 'This email is already taken.'];
        } elseif ($data['password'] !== $data['confirm-password']) {
            $this->response = $this->response->withStatus(400);
            $json = ['status' => 'error', 'message' => 'Passwords do not match.'];
        } else {
            $user->id_role = 1;
            $user->deleted = false;
            if ($usersTable->save($user)) {
                $this->response = $this->response->withStatus(201);
                $json = ['status' => 'success', 'message' => 'Registration successful.'];
            } else {
                $this->response = $this->response->withStatus(400);
                $json = ['status' => 'error', 'errors' => $user->getErrors()];
            }
        }

        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');
    }

    /**
     * Forget Password method
     *
     * @OA\Post(
     *     path="/api/v1/users/forget-password",
     *     tags={"Users"},
     *     summary="Request a password reset link",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Instructions sent to your email.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Email not found")
     * )
     */
    public function forgetPassword()
    {
        $this->request->allowMethod(['post']);
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->findByEmail($this->request->getData('email'))->first();

        if ($user) {
            // In a real app, generate token and send email here
            $json = ['status' => 'success', 'message' => 'Instructions sent to your email.'];
        } else {
            $this->response = $this->response->withStatus(404);
            $json = ['status' => 'error', 'message' => 'Email not found.'];
        }

        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void
     * @OA\Post(
     *     path="/api/v1/users/login",
     *     tags={"Users"},
     *     summary="Authenticate and get a JWT token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string"),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="email", type="string"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="role_id", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $user = $result->getData();
            $payload = [
                'sub' => $user->id,
                'exp' => time() + 3600, // 1 hour
            ];

            $json = [
                'status' => 'success',
                'data' => [
                    'token' => JWT::encode($payload, Configure::read('Api.jwtSecret', 'super-secret-key-change-this-in-env'), 'HS256'),
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                        'role_id' => $user->id_role
                    ]
                ]
            ];
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [
                'status' => 'error',
                'message' => 'Invalid credentials'
            ];
        }

        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');
    }
}
