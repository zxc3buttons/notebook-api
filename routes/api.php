<?php

use App\Http\Controllers\NotebookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('notebooks', [NotebookController::class,'index']);
Route::post('notebooks', [NotebookController::class,'store']);
Route::get('notebooks/{id}', [NotebookController::class,'show']);
Route::post('notebooks/{id}', [NotebookController::class,'update']);
Route::delete('notebooks/{id}', [NotebookController::class,'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
