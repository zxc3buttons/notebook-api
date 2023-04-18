<?php

namespace App\Http\Controllers;

use App\Http\Services\NotebookService;
use App\Http\Services\NotebookServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $notebooks = $this->notebookService->getAll();
        Log::debug('GET request for getting all notebooks: ' . $notebooks);
        return response()->json($notebooks);
    }

    /**
     * @param string $id
     * @return JsonResponse
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
