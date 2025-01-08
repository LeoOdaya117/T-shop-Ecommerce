<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\CartManager;
use App\Http\Controllers\OrderManager;
use App\Http\Controllers\ProductsManager;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('/', [ProductsManager::class,'index'])->name("home");

    Route::get("login", [AuthManager::class, "login"])->name("login");
    Route::post("login", [AuthManager::class, "loginPost"])->name("login.post");

    Route::get("register", [AuthManager::class, "registration"])->name("register");
    Route::post("register", [AuthManager::class, "registrationPost"])
        ->name("register.post");

    Route::get("logout", [AuthManager::class, "logout"])->name("logout");

    Route::get("/product/{slug}", [ProductsManager::class, "showDetails"])
        ->name("showDetails");

    Route::get('/products', [ProductsManager::class,'index'])->name("recommended");

    Route::middleware("auth")->group(function(){

        Route::get('/cart/{id}/{quantity}', [CartManager::class, 'addToCart'])
        ->name('cart.add');
        Route::get('/remove_item/{id}', [CartManager::class, 'deleteFromCart'])
        ->name('cart.remove');
        Route::get('/add_quantity/{id}/{quantity}', [CartManager::class, 'updateQuantity'])
        ->name('add.quantity');
        Route::get("/cart", [CartManager::class, "showCart"])->name("cart.show");

        Route::get("/checkout", [OrderManager::class, "showCheckout"])
        ->name("checkout.show");
        Route::post("/checkout", [OrderManager::class, "checkoutPost"])
        ->name("checkout.post");

        Route::get('/payment/success/{order_id}', [OrderManager::class, 'paymentSuccess'])
            ->name('payment.success');
        Route::get('/payment/error', [OrderManager::class, 'paymentError'])
            ->name('payment.error');

        Route::get('/order-history/{status}', [OrderManager::class, 'orderHistory'])
            ->name('order.history');
        Route::get('/order-details/{id}', [OrderManager::class, 'orderDetails'])
            ->name('order.details');


});