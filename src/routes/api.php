<?php

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserAthleticProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user/create-account', [UserController::class, 'create']);
Route::post('/user/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/athletic-profile', [UserAthleticProfileController::class, 'create']);
});
