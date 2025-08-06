<?php

use App\Http\Controllers\AddOnFeatureController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Users;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Routes
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login', [AdminController::class, 'loginPost']);
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');

    // Category Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('store', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::post('update', [ProductCategoryController::class, 'update'])->name('update');
        Route::get('view/{id}', [ProductCategoryController::class, 'view'])->name('view');
        Route::get('delete/{id}', [ProductCategoryController::class, 'delete'])->name('delete');
        Route::post('search', [ProductCategoryController::class, 'search'])->name('search');
        Route::post('add_sub', [ProductCategoryController::class, 'add_sub_category'])->name('add_sub_category');
        Route::get('{category}/sub/delete/{id}', [ProductCategoryController::class, 'delete_sub_category'])->name('delete_sub_category');
    });

    // Products Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        // Route::get('create/{category_id}', [ProductController::class, 'create'])->name('create_category');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update', [ProductController::class, 'update'])->name('update');
        Route::get('view/{id}', [ProductController::class, 'view'])->name('view');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('delete');
        Route::post('search', [ProductController::class, 'search'])->name('search');
        Route::get('images/{product_id}', [ProductController::class, 'images'])->name('images');
        Route::post('images/{product_id}', [ProductController::class, 'storeImages'])->name('storeImages');
        Route::get('/{product_id}/images/delete/{id}', [ProductController::class, 'deleteImage'])->name('deleteImage');

        Route::get('sizes/{product_id}', [ProductController::class, 'sizes'])->name('sizes');
        Route::post('sizes/{product_id}', [ProductController::class, 'storeSizes'])->name('storeSizes');
        Route::get('/{product_id}/sizes/delete/{id}', [ProductController::class, 'deleteSizes'])->name('deleteSizes');
        Route::post('update_sizes/update', [ProductController::class, 'updateSize'])->name('updateSize');

        Route::any("{any}", function () {
            return redirect()->route('admin.products.index');
        });
    });
    Route::prefix('addons')->name('add_ons.')->group(function(){
        Route::get('/',[AddOnFeatureController::class, 'index'])->name('index');
        Route::get('create', [AddOnFeatureController::class, 'create'])->name('create');
        Route::get('create_with_product/{id}', [AddOnFeatureController::class, 'create_with_product'])->name('create_with_product');
        Route::post('store', [AddOnFeatureController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AddOnFeatureController::class, 'edit'])->name('edit');
        Route::post('update', [AddOnFeatureController::class, 'update'])->name('update');
        Route::get('view/{id}', [AddOnFeatureController::class, 'view'])->name('view');
        Route::get('delete/{id}', [AddOnFeatureController::class, 'delete'])->name('delete');
        Route::post('search', [AddOnFeatureController::class, 'search'])->name('search');

        Route::any("{any}", function () {
            return redirect()->route('admin.add_ons.index');
        });
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [Users::class, 'view'])->name('view');
        Route::post('search', [Users::class, 'search'])->name('search');
        Route::get('ratings', [Users::class, 'ratings'])->name('ratings');
        Route::get('reviews/{product_id}', [Users::class, 'reviews'])->name('reviews');
        Route::get('comments', [Users::class, 'comments'])->name('comments');
        Route::post('respond', [Users::class, 'respond'])->name('respond');
        Route::get('product_comments/{product_id}', [Users::class, 'product_comments'])->name('product_comments');
    });


    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::post('search', [ContactController::class, 'search'])->name('search');
        Route::get('respond/{id}', [ContactController::class, 'respond'])->name('respond');
        Route::get('delete/{id}', [ContactController::class, 'delete'])->name('delete');
        Route::get('replied/{id}', [ContactController::class, 'replied'])->name('replied');
    });

     Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::post('search', [AdminOrderController::class, 'search'])->name('search');

        Route::get('active', [AdminOrderController::class, 'active'])->name('active');

        Route::get('shipped', [AdminOrderController::class, 'shipped'])->name('shipped');

        Route::get('delivered', [AdminOrderController::class, 'delivered'])->name('delivered');

        Route::get('completed', [AdminOrderController::class, 'completed'])->name('completed');

        Route::post('shippment_process/', [AdminOrderController::class, 'shippment_process'])->name('shippment_process');
        Route::post('shippment_submit', [AdminOrderController::class, 'shippment_submit'])->name('shippment_submit');

        Route::get('delivered_submit/{id}', [AdminOrderController::class, 'delivered_submit'])->name('delivered_submit');
        Route::get('completed_submit/{id}', [AdminOrderController::class, 'completed_submit'])->name('completed_submit');

        Route::get('verify/{id}/{status}', [AdminOrderController::class, 'verify'])->name('verify');
    });

    Route::get('/sub_categories/fetch/{id}',[ProductController::class,'getSubCategories']);
    Route::get('settings',[SettingsController::class,'index'])->name('settings');
    Route::post('settings/update',[SettingsController::class,'update']);

    Route::any("{any}", function () {
        return redirect()->route('admin.login');
    });

});
