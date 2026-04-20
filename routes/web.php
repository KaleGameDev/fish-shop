<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WarehouseProductController;
use App\Http\Controllers\WarehouseOrderController;

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
    Route::get('/checkout/success/{order}', [CartController::class, 'thankYou'])->name('cart.success');
    Route::get('/orders/history', [CartController::class, 'orderHistory'])->name('orders.history');
    Route::get('/orders/history/{order}', [CartController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [CartController::class, 'cancel'])->name('orders.cancel');
});

Route::resource('users', UserController::class)->middleware(['auth', 'admin']);
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Route Xử lý thanh toán
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/checkout/vnpay/return', [App\Http\Controllers\CartController::class, 'vnpayReturn'])->name('checkout.vnpay.return');
    Route::get('/checkout/vnpay/{order}', [App\Http\Controllers\CartController::class, 'vnpayPayment'])->name('checkout.vnpay');
    // Gửi đánh giá sản phẩm
    Route::post('/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});


// ĐÃ CẬP NHẬT MIDDLEWARE: Nhóm dành riêng cho Kho (có prefix warehouse)
Route::middleware(['auth', 'admin'])->prefix('warehouse')->name('warehouse.')->group(function () {
    Route::get('/products', [WarehouseProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [WarehouseProductController::class, 'create'])->name('products.create');
    Route::post('/products', [WarehouseProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [WarehouseProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [WarehouseProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [WarehouseProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/orders', [WarehouseOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [WarehouseOrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::delete('/orders/{order}', [WarehouseOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/dashboard', [App\Http\Controllers\WarehouseDashboardController::class, 'index'])->name('dashboard');
});

// ĐÃ SỬA LỖI Ở ĐÂY: Tạo một nhóm TÁCH BIỆT dành cho Admin nhưng không bị kẹt cái chữ "warehouse."
Route::middleware(['auth', 'admin'])->group(function () {
    // Quản lý Đánh giá
    Route::get('/admin/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::patch('/admin/reviews/{review}/toggle', [App\Http\Controllers\Admin\ReviewController::class, 'toggle'])->name('admin.reviews.toggle'); // <- Dòng mới thêm
    Route::delete('/admin/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});