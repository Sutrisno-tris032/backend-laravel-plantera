<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Master\LookupStatusController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Auth\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Auth\LoginController::class)->name('login');

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', App\Http\Controllers\Auth\LogoutController::class)->name('logout');


/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('jwt')->group(function () {
//     Route::get('/user', [AuthController::class, 'getUser']);
//     Route::put('/user', [AuthController::class, 'updateUser']);
//     Route::post('/logout', [AuthController::class, 'logout']);
// });
Route::middleware('jwt')->group(function () {
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

    Route::prefix('lookup')->group(function () {
        Route::get('/status/{category_id}', [LookupStatusController::class,'lookupStatus']); // GET /lookup/status/{categpory_id}
    });
});
