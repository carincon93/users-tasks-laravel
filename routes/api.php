<?php

use Illuminate\Support\Facades\Route;

use App\Users\UserController;

Route::resource('/users', UserController::class);
