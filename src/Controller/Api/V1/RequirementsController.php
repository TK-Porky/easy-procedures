<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use OpenApi\Annotations as OA;

/**
 * Requirements API Controller
 */
class RequirementsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     * 
     * @OA\Get(
     *     path="/api/v1/requirements",
     *     tags={"Requirements"},
     *     summary="List all requirements",
     *     security={{"BearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Requirement"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $requirements = $this->Requirements->find('all')
            ->where(['Requirements.deleted' => false])
            ->contain(['Requirementtypes'])
            ->all();

        $this->set([
            'status' => 'success',
            'data' => $requirements
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    /**
     * View method
     * 
     * @OA\Get(
     *     path="/api/v1/requirements/{id}",
     *     tags={"Requirements"},
     *     summary="Get a requirement by ID",
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
     *             @OA\Property(property="data", ref="#/components/schemas/Requirement")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Requirement not found")
     * )
     */
    public function view($id = null)
    {
        $requirement = $this->Requirements->get($id, [
            'contain' => ['Requirementtypes', 'Requirementproprieties'],
        ]);

        $this->set([
            'status' => 'success',
            'data' => $requirement
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }
}
