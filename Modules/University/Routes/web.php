<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\University\Http\Controllers\Dashboard\LevelController;
use Modules\University\Http\Controllers\Dashboard\UniversityController;

Route::middleware('auth:web')->name('admin.')->prefix('admin')->group(function () {
    Route::resource('university', UniversityController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

});



Route::middleware('auth:web')->name('admin.university.level.')->prefix('admin')->controller(LevelController::class)->group(function () {
    Route::get('/{id}' , 'index')->name('index');
        Route::get('/edit/{type}' , 'edit')->name('edit');
        Route::post('/store/{id}' , 'store')->name('store');
        Route::put('/update/{type}' , 'update')->name('update');
        Route::delete('/delete/{type}' , 'destroy')->name('destroy');

});