
<?php

use App\Http\Controllers\CartItemController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\Users;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Route;

Route::post('register', [Users::class, 'store']);
Route::post('login', [Users::class, 'login']);
Route::get('login', [Users::class, 'login_view'])->name('login');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [Users::class, 'index'])->name('home');
    Route::get('logout', [Users::class, 'logout'])->name('logout');
    Route::get('dashboard', [Users::class, 'dashboard'])->name('dashboard');
    Route::get('settings', [Users::class, 'settings'])->name('settings');
    Route::post('/update/settings', [Users::class, 'setSettings'])->name('set_settings');
    Route::post('/update/account', [Users::class, 'setAccount'])->name('set_account');

    Route::prefix('cart')->name('cart.')->group(function(){
        Route::get('/', [CartItemController::class, 'index'])->name('cart');
        Route::get('add/{product_id}', [CartItemController::class, 'addToCart'])->name('add_cart');
        Route::get('remove/{id}', [CartItemController::class, 'remove'])->name('remove');
        Route::get('checkout', [CartItemController::class, 'checkout'])->name('checkout');
    });

    Route::prefix('favourites')->name('favourites.')->group(function(){
        Route::get('/', [FavouriteController::class, 'index']);
        Route::get('add/{product_id}', [FavouriteController::class, 'add'])->name('add');
        Route::get('remove/{id}', [FavouriteController::class, 'remove'])->name('remove');
    });

    Route::prefix('product')->name('product')->group(function(){
        Route::post('ratings',[ProductReviewController::class, 'ratings'])->name('ratings');
        Route::post('comments',[ProductReviewController::class, 'comments'])->name('comments');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'orders'])->name('index');
        Route::post('order_now', [OrderController::class, 'order_now'])->name('order_now');
        Route::post('single_order', [OrderController::class, 'single_order'])->name('single_order');
        Route::get('payment_process', [OrderController::class, 'payment_process'])->name('payment_process');
        Route::post('make_payment', [OrderController::class, 'make_payment'])->name('make_payment');
        Route::get('cancel/{id}', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('recieved/{id}', [OrderController::class, 'recieved'])->name('recieved');
    });
});
