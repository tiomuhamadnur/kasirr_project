<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BackupController;
use App\Http\Controllers\API\LicenseController;
use App\Http\Controllers\API\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('me', [UserController::class, 'me']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('backup', BackupController::class);
    Route::apiResource('license', LicenseController::class);
});
