<?php

namespace App\Http\Controllers;

use App\Http\Services\NotebookService;
use App\Http\Services\NotebookServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="My API",
 *      description="API description",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */
class NotebookController extends Controller
{
    /**
     * @var NotebookServiceImpl
     */
    private NotebookService $notebookService;

    public function __construct(NotebookService $notebookService)
    {
        $this->notebookService = $notebookService;
    }

    /**
     * Get a list of all users
     *
     * @OA\Get(
     *     path="/api/notebooks",
     *     summary="Get a list of all notebooks",
     *     operationId="getAllNotebooks",
     *     tags={"Notebooks"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="./openapi.yaml")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $notebooks = $this->notebookService->getAll();
        Log::debug('GET request for getting all notebooks: ' . $notebooks);
        return response()->json($notebooks);
    }

    /**
     * @OA\Get(
     *     path="/api/notebooks/{id}",
     *     summary="Get a single notebook",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns the notebook",
     *         @OA\JsonContent(ref="./openapi.yaml")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Notebook not found"
     *     ),
     *)
     */
    public function show(string $id): JsonResponse
    {
        $notebook = $this->notebookService->getOne($id);
        Log::debug('GET request for getting notebook with id ' . $id . ': ' . $notebook);
        return response()->json($notebook);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $notebook = $this->notebookService->create($request->all());
        Log::debug('POST request for creating notebook. Created entity: ' . $notebook);
        return response()->json($notebook, 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $notebook = $this->notebookService->update($request);
        Log::debug('POST request for updating notebook. Updated entity: ' . $notebook);
        return response()->json($notebook);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $this->notebookService->delete($id);
        Log::debug('DELETE request for deleting notebook.');
        return response()->json(['Notebook deleted successfully'], 204);
    }
}
