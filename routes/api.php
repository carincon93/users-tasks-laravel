<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureUserHasRole;
use App\Users\UserController;
use App\Auth\AuthController;
use App\Tasks\TaskController;
use App\Roles\RoleController;

Route::prefix(config('app.api_prefix'))->group(function () {
    Route::middleware('throttle:global')->group(function () {

        Route::prefix('auth')->group(function () {
            Route::post('register', [AuthController::class, 'register']);
            Route::post('login', [AuthController::class, 'login']);
            Route::post('refresh', [AuthController::class, 'refresh']);
        });

        Route::middleware('auth:api')->group(function () {
            Route::prefix('auth')->group(function () {
                Route::post('profile', [AuthController::class, 'profile']);
                Route::post('logout', [AuthController::class, 'logout']);
            });

            Route::middleware(EnsureUserHasRole::class . ':admin')->group(function () {
                Route::apiResource('users', UserController::class);
                Route::apiResource('roles', RoleController::class);
            });

            Route::middleware(EnsureUserHasRole::class . ':basic')->group(function () {
                Route::apiResource('tasks', TaskController::class);
            });
        });
    });
});
