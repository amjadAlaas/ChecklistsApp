<?php

use App\Http\Controllers\Api\ChecklistController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TaskController;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/checklists', [ChecklistController::class, 'index']);
    Route::get('/checklist/{id}', [ChecklistController::class, 'show']);
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::post('/checklist/{id}', [ChecklistController::class, 'update']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'destroy']);
    Route::post('/logout', [LoginController::class, 'logout']);
    ///tasks routes
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/task', [TaskController::class, 'store']);
    Route::post('/task', [TaskController::class, 'update']);
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
