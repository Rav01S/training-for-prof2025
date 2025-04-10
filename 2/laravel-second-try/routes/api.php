<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Categories\CategoriesController;
use App\Http\Controllers\API\Orders\OrdersController;
use App\Http\Controllers\API\Products\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'welcome'
    ]);
});


Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/registration', [AuthController::class, 'registration']);

Route::withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)->group(function () {
    Route::post('/payments/webhook', [OrdersController::class, 'webhook']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::get('/categories/{category}/products', [CategoriesController::class, 'show']);
    Route::get('/products/{product}', [ProductsController::class, 'show']);

    Route::get('/orders', [OrdersController::class, 'index']);

    Route::post('/products/{product}/buy', [OrdersController::class, 'store']);
});
