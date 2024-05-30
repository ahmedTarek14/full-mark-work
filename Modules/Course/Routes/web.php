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
use Modules\Course\Http\Controllers\Dashboard\CourseController;

Route::middleware('auth:web')->name('admin.')->prefix('admin')->group(function () {
    Route::resource('course', CourseController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('course/update-default/{course}', [CourseController::class, 'update_default'])->name('course.update_default');

    Route::post('levels-ajax', [CourseController::class, 'levels'])->name('ajax.levels');
});
