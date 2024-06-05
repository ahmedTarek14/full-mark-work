<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\AuthController;

Route::name('auth.')
    ->prefix('')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('auth/login', 'login')->name('login');
        Route::post('auth/verify', 'verify')->name('verify');
        Route::post('auth/register', 'register')->name('register');
        Route::post('auth/resend-code', 'resendCode')->name('resendCode');
        Route::post('auth/logout', 'logout')->name('logout')->middleware('auth:sanctum');
        Route::post('auth/change-password-logged', 'change_password_logged')->name('change_password_logged')->middleware('auth:sanctum');
        Route::post('auth/forget-password', 'forget_password')->name('forget_password');
        Route::post('auth/change-password', 'change_password')->name('change_password');
        Route::get('profile/logged-user', 'logged_user')->name('logged_user')->middleware('auth:sanctum');
        Route::get('profile/my-courses', 'my_courses')->name('my_courses')->middleware('auth:sanctum');
        Route::delete('profile/delete-account', 'delete_account')->name('delete_account')->middleware('auth:sanctum');
    });
