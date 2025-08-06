<?php

use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

include __DIR__."\user.php";
include __DIR__."\admin.php";

// Route::get('api/orders',function(){
//     $orders = Order::all();
//     return response()->json($orders);
// });

// Route::get('api/order/{id}',function($id){
//     $order = Order::find($id);
//     return response()->json($order);
// });

// Route::get('api/products',function(){
//     $products = Product::all();
//     return response()->json($products);
// });

// Route::get('api/product/{id}',function($id){
//     $product = Product::find($id);
//     return response()->json($product);
// });



Route::get('/', [HomeController::class, 'home'])->name('home');

Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [HomeController::class, 'contact'])->name('contact');
    Route::post('/submit', [HomeController::class, 'contact_submit'])->name('submit');
});

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/new', [HomeController::class, 'arrivals'])->name('arrivals');
    Route::get('category/{id}', [HomeController::class, 'category'])->name('category');
    Route::get('perfumes', [HomeController::class, 'perfumes'])->name('perfumes');
    Route::get('category/{id}/sub/{sub}', [HomeController::class, 'category_with_sub'])->name('category_with_sub');
    Route::get('details/{id}', [HomeController::class, 'details'])->name('detail');
    Route::any('{any}',function(){
        return redirect()->route("product.index");
    });
});

Route::get('register', [HomeController::class, 'register'])->name('register');
Route::any('{any}',function(){
    return redirect()->route('home');
});
