<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use OpenApi\Annotations as OA;

/**
 * Procedures API Controller
 * 
 * @OA\Tag(name="Procedures", description="Management of bank procedures")
 */
class ProceduresController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     * 
     * @OA\Get(
     *     path="/api/v1/procedures",
     *     tags={"Procedures"},
     *     summary="List all active procedures",
     *     security={{"BearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Procedure"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $procedures = $this->Procedures->find('all')
            ->where(['deleted' => false])
            ->all();

        $this->set([
            'status' => 'success',
            'data' => $procedures
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    /**
     * View method
     * 
     * @OA\Get(
     *     path="/api/v1/procedures/{id}",
     *     tags={"Procedures"},
     *     summary="Get a procedure by ID",
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
     *             @OA\Property(property="data", ref="#/components/schemas/Procedure")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Procedure not found")
     * )
     */
    public function view($id = null)
    {
        $procedure = $this->Procedures->get($id, [
            'contain' => ['Procedurerequirements'],
        ]);

        $this->set([
            'status' => 'success',
            'data' => $procedure
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }
}
