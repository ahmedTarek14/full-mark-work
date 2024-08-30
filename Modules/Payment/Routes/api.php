<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\Api\PaymentController;

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

Route::prefix('payment')->group(function () {
    Route::post('/create', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::any('/response', [PaymentController::class, 'handlePaymentResponse'])->name('payment.handleResponse');
});
