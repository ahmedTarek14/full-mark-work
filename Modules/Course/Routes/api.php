<?php
use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Api\CourseController;

Route::prefix('courses')
    ->group(function () {
        Route::get('/all', [CourseController::class, 'index'])->name('course.all')->middleware('auth:sanctum');
        Route::get('/default', [CourseController::class, 'default'])->name('course.default');
        Route::get('/links/{id}', [CourseController::class, 'links'])->name('links.all');

    });
