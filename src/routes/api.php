<?php

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user/create-account', [UserController::class, 'create']);
Route::post('/user/login', [LoginController::class, 'login']);
