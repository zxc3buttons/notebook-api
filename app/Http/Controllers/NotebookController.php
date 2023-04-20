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
     * Store a new notebook.
     *
     * @OA\Post(
     *     path="/api/notebooks",
     *     tags={"Notebooks"},
     *     summary="Create a new notebook",
     *     description="Store a new notebook in the database",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"full_name", "phone", "email"},
     *                 @OA\Property(property="full_name", type="string", example="John Doe"),
     *                 @OA\Property(property="company", type="string", example="Google"),
     *                 @OA\Property(property="phone", type="string", example="+1234567890"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                 @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
     *                 @OA\Property(property="image_link", type="string", example="https://example.com/image.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Notebook created successfully",
     *         @OA\JsonContent(ref="./openapi.yaml")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation error",
     *         @OA\JsonContent(ref="./openapi.yaml")
     *     )
     * )
     *
     * @param Request $request The HTTP request instance
     * @return JsonResponse The JSON response instance
     * @throws ValidationException When validation fails
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
     * Update an existing notebook
     * @OA\Post(
     * path="/api/notebooks/{id}",
     * operationId="updateNotebook",
     * tags={"Notebooks"},
     * summary="Update an existing notebook",
     * description="Update an existing notebook",
     * @OA\Parameter(
     * name="id",
     * description="ID of notebook",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Request body for updating notebook",
     * @OA\JsonContent(
     * @OA\Property(
     * property="id",
     * type="integer"
     * ),
     * @OA\Property(
     * property="full_name",
     * type="string"
     * ),
     * @OA\Property(
     * property="company",
     * type="string"
     * ),
     * @OA\Property(
     * property="phone",
     * type="string"
     * ),
     * @OA\Property(
     * property="email",
     * type="string",
     * format="email"
     * ),
     * @OA\Property(
     * property="birth_date",
     * type="date"
     * ),
     * @OA\Property(
     * property="image_link",
     * type="string"
     * ),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Notebook updated successfully",
     * @OA\JsonContent(ref="./openapi.yaml")
     * ),
     * @OA\Response(
     * response=404,
     * description="Notebook not found"
     * ),
     * @OA\Response(
     * response=422,
     * description="Unprocessable Entity"
     * )
     * )
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
     * Delete the notebook by given id.
     *
     * @OA\Delete(
     * path="/api/notebooks/{id}",
     * operationId="deleteNotebookById",
     * tags={"Notebooks"},
     * summary="Delete the notebook by given id",
     * description="Deletes the notebook by given id and returns a success message.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the notebook to delete",
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\Response(
     * response=204,
     * description="Notebook deleted successfully"
     * ),
     * @OA\Response(
     * response=404,
     * description="Notebook not found"
     * ),
     * @OA\Response(
     * response=500,
     * description="Server error"
     * )
     * )
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
