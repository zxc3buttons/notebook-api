<?php

namespace App\Http\Controllers;

use App\Http\Services\NotebookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    /**
     * @var NotebookService
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
        return response()->json($this->notebookService->getAll());
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        return response()->json($this->notebookService->getOne($id));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json($this->notebookService->create($request->all()), 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        return response()->json($this->notebookService->update($request));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $this->notebookService->delete($id);
        return response()->json(['Notebook deleted successfully'], 204);
    }
}
