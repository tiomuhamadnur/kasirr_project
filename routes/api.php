<?php

use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BackupController;
use App\Http\Controllers\API\LicenseController;
use App\Http\Controllers\API\PromoController;
use App\Http\Controllers\API\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('/forget-password/send-email', 'sendForgetPasswordEmail');
    Route::post('/forget-password/verify', 'verifyForgetPassword');
});

Route::middleware(['auth:api'])->group( function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('resend-activation-email', 'resendActivationEmail');
        Route::post('verify-activation-code', 'verifyActivationCode');
        Route::post('logout', 'logout');
    });
});

Route::middleware(['auth:api', 'email_verified'])->group( function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index');
        Route::post('/user', 'update');
        Route::post('/user/photo-profile', 'update_photo_profile');

        // Password
        Route::post('/user/password/update', 'update_password');

        // PIN
        Route::post('/user/pin/create', 'create_pin');
        Route::post('/user/pin/update', 'update_pin');
        Route::post('/user/pin/forget/send-email', 'sendForgetPinEmail');
        Route::post('/user/pin/forget/verify', 'verifyForgetPin');
    });

    Route::apiResource('backup', BackupController::class);
    Route::apiResource('license', LicenseController::class);
    Route::apiResource('asset', AssetController::class);
    Route::apiResource('promo', PromoController::class);
});
