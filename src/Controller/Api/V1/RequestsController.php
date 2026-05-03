<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use OpenApi\Annotations as OA;

/**
 * Requests API Controller
 */
class RequestsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     * 
     * Returns requests for the authenticated user.
     * 
     * @OA\Get(
     *     path="/api/v1/requests",
     *     tags={"Requests"},
     *     summary="List all requests for the authenticated user",
     *     security={{"BearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Request"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $user = $this->Authentication->getIdentity();
        $requests = $this->Requests->find('all')
            ->where(['user_id' => $user->getIdentifier(), 'deleted' => false])
            ->contain(['Procedures'])
            ->all();

        $this->set([
            'status' => 'success',
            'data' => $requests
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    /**
     * View method
     * 
     * @OA\Get(
     *     path="/api/v1/requests/{id}",
     *     tags={"Requests"},
     *     summary="Get a request by ID",
     *     security={{"BearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Request")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Request not found")
     * )
     */
    public function view($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $request = $this->Requests->find('all')
            ->where(['Requests.id' => $id, 'user_id' => $user->getIdentifier(), 'Requests.deleted' => false])
            ->contain(['Procedures', 'Requestrequirements' => ['Requestrequirementproprieties' => ['Requirementproprieties']]])
            ->firstOrFail();

        $this->set([
            'status' => 'success',
            'data' => $request
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    /**
     * Add method (Start a new procedure request)
     * 
     * @OA\Post(
     *     path="/api/v1/requests",
     *     tags={"Requests"},
     *     summary="Start a new procedure request",
     *     security={{"BearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"procedure_id"},
     *             @OA\Property(property="procedure_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Request")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $user = $this->Authentication->getIdentity();
        
        $request = $this->Requests->newEmptyEntity();
        $request = $this->Requests->patchEntity($request, $this->request->getData());
        $request->user_id = $user->getIdentifier();
        $request->status = 'Draft';
        $request->deleted = false;

        if ($this->Requests->save($request)) {
            $this->set([
                'status' => 'success',
                'data' => $request
            ]);
        } else {
            $this->response = $this->response->withStatus(400);
            $this->set([
                'status' => 'error',
                'errors' => $request->getErrors()
            ]);
        }
        $this->viewBuilder()->setOption('serialize', ['status', 'data', 'errors']);
    }
}
