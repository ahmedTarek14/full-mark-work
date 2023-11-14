<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Dashboard\AuthController;
use Modules\Auth\Http\Controllers\Dashboard\UserController;

Route::middleware('web')
    ->name('admin.')
    ->prefix('admin/')
    ->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

Route::middleware('auth:web')->name('admin.')->prefix('admin')->group(function () {
    Route::resource('user', UserController::class)->only(['index', 'destroy']);
    Route::get('user/update-status/{user}', [UserController::class, 'update_status'])->name('user.update_status');
});