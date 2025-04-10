<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'welcome']);
})->name('api.welcome');


Route::post('/payments/webhook', [OrdersController::class, 'webhook']);


Route::post('/auth', [AuthController::class, 'login'])->name('api.login.store');
Route::post('/registration', [AuthController::class, 'register'])->name('api.register.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::get('/categories/{category}/products', [CategoriesController::class, 'show']);
    Route::get('/products/{product}', [ProductsController::class, 'show']);
    Route::post('/products/{product}/buy', [OrdersController::class, 'store']);

    Route::get('/orders', [OrdersController::class, 'index']);
});
