<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',          [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [Admin\DashboardController::class, 'index']);

    // Products CRUD
    Route::resource('products', Admin\ProductController::class);

    // Orders
    Route::get('/orders',         [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');

    // Customers
    Route::get('/customers',            [Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [Admin\CustomerController::class, 'show'])->name('customers.show');

    // Settings
    Route::get('/settings',  fn() => view('admin.settings.index'))->name('settings');
    Route::put('/settings',  fn() => back()->with('success', 'Settings saved.'))->name('settings.update');
});
