<?php

use App\Http\Controllers\AdminPanel\AuthController;
use App\Http\Controllers\AdminPanel\CategoriesController;
use App\Http\Controllers\AdminPanel\OrdersController;
use App\Http\Controllers\AdminPanel\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'index'])->name('admin.login.index');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.login.logout');

    // Товары
    Route::get('/admin/products', [ProductsController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/products/{product}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
    Route::get('/admin/products/{product}', [ProductsController::class, 'show'])->name('admin.products.show');
    Route::post('/admin/products', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{product}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');

    // Категории
    Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
    Route::get('/admin/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::get('/admin/categories/{category}', [CategoriesController::class, 'show'])->name('admin.categories.show');
    Route::post('/admin/categories', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::put('/admin/categories/{category}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

    // Заказы
    Route::get('/admin/orders', [OrdersController::class, 'index'])->name('admin.orders.index');
});
