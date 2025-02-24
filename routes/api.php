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

Route::middleware(['auth:api'])->group( function () {
    Route::post('resend-activation-email', [AuthController::class, 'resendActivationEmail']);
    Route::post('verify-activation-code', [AuthController::class, 'verifyActivationCode']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'email_verified'])->group( function () {
    Route::get('user', [UserController::class, 'index']);
    Route::post('user', [UserController::class, 'update']);
    Route::post('user/photo-profile', [UserController::class, 'update_photo_profile']);

    Route::apiResource('backup', BackupController::class);
    Route::apiResource('license', LicenseController::class);
});
