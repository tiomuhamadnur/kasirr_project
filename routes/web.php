<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\GroupController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\StatusController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\BackupController;
use App\Http\Controllers\user\LicenseController;
use App\Http\Controllers\user\ProjectController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->middleware('guest');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $r) {
    $r->user()->sendEmailVerificationNotification();
    return back()->with('resent', 'Verification link sent ');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $r) {
    $r->fulfill();
    return redirect()->route('dashboard.index')->withNotify('Alamat email anda berhasil diverifikasi.');
})->middleware(['auth', 'signed'])->name('verification.verify');


Auth::routes();

Route::get('/home', function () {
    return redirect()->route('dashboard.index');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/dashboard', DashboardController::class);

    Route::resource('/user', UserController::class);

    Route::resource('/role', RoleController::class);

    Route::resource('/gender', GenderController::class);

    Route::resource('/category', CategoryController::class);

    Route::resource('/status', StatusController::class);

    Route::resource('/group', GroupController::class);

    Route::resource('/license', LicenseController::class);

    Route::resource('/project', ProjectController::class);

    Route::resource('/backup', BackupController::class);
});
