<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/payments', [PaymentController::class, 'createPayment']);
Route::get('/pay/{orderId}', [PaymentController::class, 'showForm'])->name('payment.form');
Route::post('/pay/{orderId}', [PaymentController::class, 'submitForm'])->name('payment.submit');
