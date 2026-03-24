<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WarehouseAuthController;
use App\Http\Controllers\WarehouseProductController;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('shop.show');

// Dashboard: login xong sẽ về đây theo Breeze, ta redirect về shop
Route::get('/dashboard', function () {
    return redirect()->route('shop.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('users', UserController::class);
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::get('/warehouse/login', [WarehouseAuthController::class, 'showLoginForm'])
    ->name('warehouse.login.form');

Route::post('/warehouse/login', [WarehouseAuthController::class, 'login'])
    ->name('warehouse.login');

Route::post('/warehouse/logout', [WarehouseAuthController::class, 'logout'])
    ->name('warehouse.logout');

Route::middleware('warehouse.auth')->prefix('warehouse')->name('warehouse.')->group(function () {
    Route::get('/products', [WarehouseProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [WarehouseProductController::class, 'create'])->name('products.create');
    Route::post('/products', [WarehouseProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [WarehouseProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [WarehouseProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [WarehouseProductController::class, 'destroy'])->name('products.destroy');
});