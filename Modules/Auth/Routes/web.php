<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Dashboard\AuthController;

Route::middleware('web')
    ->name('admin.')
    ->prefix('admin/')
    ->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
