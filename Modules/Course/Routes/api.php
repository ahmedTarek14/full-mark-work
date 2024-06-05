<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Api\CourseController;

Route::prefix('courses')
    ->group(function () {
        Route::get('/all/{type_id}', [CourseController::class, 'index'])->name('course.all')->middleware('auth:sanctum');
        Route::get('/default/{type_id}', [CourseController::class, 'default'])->name('course.default');
        Route::get('/links/{course}', [CourseController::class, 'links'])->name('links.all');
    });
