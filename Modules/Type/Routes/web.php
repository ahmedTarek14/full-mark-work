<?php

/**
 * dashboard page Routes
 */

use Illuminate\Support\Facades\Route;
use Modules\Type\Http\Controllers\Dashboard\TypeController;

Route::middleware('auth:web')->name('admin.')->prefix('admin')->group(function () {
    Route::resource('type', TypeController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

});
