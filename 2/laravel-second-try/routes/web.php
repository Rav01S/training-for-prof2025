<?php

use App\Http\Controllers\Admin\Categories\CategoriesController;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\Orders\OrdersController;
use App\Http\Controllers\Admin\Products\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'store'])->name('admin.login.store');
});

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.login.logout');

    Route::resource('/admin/categories', CategoriesController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'edit' => 'admin.categories.edit',
        'show' => 'admin.categories.show',
        'update' => 'admin.categories.update',
        'store' => 'admin.categories.store',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::resource('/admin/products', ProductsController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'edit' => 'admin.products.edit',
        'show' => 'admin.products.show',
        'update' => 'admin.products.update',
        'store' => 'admin.products.store',
        'destroy' => 'admin.products.destroy',
    ]);

    Route::get('/admin/orders', [OrdersController::class, 'index'])->name('admin.orders.index');
});
