<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']); // GET /projects
    Route::post('/submit', [ProjectController::class, 'store']); // POST /projects/submit
    Route::put('{project_uid}/update', [ProjectController::class, 'update']); // PUT /projects/{project_uid}
    Route::delete('{project_uid}', [ProjectController::class, 'destroy']); // DELETE /projects/{project_uid}
});

Route::prefix('task')->group(function () {
    Route::get('/', [TaskController::class, 'index']); // GET /task
    Route::get('/{task_uid}', [TaskController::class, 'show']); // GET /task/{task_uid}
    Route::post('/submit', [TaskController::class, 'store']); // POST /task/submit
    Route::put('/{task_uid}/update-status', [TaskController::class, 'updateStatus']); // PUT /task/{task_uid}/update-status
    Route::put('/{task_uid}/update', [TaskController::class, 'update']); // PUT /task/{task_uid}/update
    Route::delete('/{task_uid}', [TaskController::class, 'destroy']); // DELETE /task/{task_uid}
});

Route::prefix('sprint')->group(function () {
    Route::get('/', [SprintController::class, 'index']); // GET /sprint
    Route::get('/{sprint_uid}', [SprintController::class, 'show']); // GET /sprint/{sprint_uid}
    Route::post('/submit', [SprintController::class, 'store']); // POST /sprint/submit
    Route::put('/{sprint_uid}/update', [SprintController::class, 'update']); // PUT /sprint/{sprint_uid}/update
    Route::delete('/{sprint_uid}', [SprintController::class, 'destroy']); // DELETE /sprint/{sprint_uid}
});
