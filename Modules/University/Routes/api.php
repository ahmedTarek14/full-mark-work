<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\Api\UniversityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('universities')
    ->group(function () {
        Route::get('/all', [UniversityController::class, 'index'])->name('university.all')->middleware('auth:sanctum');
    });
