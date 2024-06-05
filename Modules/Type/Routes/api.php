<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Type\Http\Controllers\Api\LevelController;

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

Route::prefix('levels')
    ->group(function () {
        Route::get('/{university_id}', [LevelController::class, 'index'])->name('level.all');
    });
