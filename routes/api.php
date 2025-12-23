<?php

use Illuminate\Support\Facades\Route;

use App\Users\UserController;
use App\Auth\AuthController;
use App\Tasks\TaskController;

Route::prefix(env('API_PREFIX'))->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::resource('/users', UserController::class);
        Route::resource('/tasks', TaskController::class);
    });
});
