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
    Route::get('shop', [ProductsManager::class,'showProducts'])->name("shop");
    //LOGIN ROUTES
    Route::get("login", [AuthManager::class, "login"])->name("login");
    Route::post("login", [AuthManager::class, "loginPost"])->name("login.post");
    // REGISTER ROUTES
    Route::get("register", [AuthManager::class, "registration"])->name("register");
    Route::post("register", [AuthManager::class, "registrationPost"])
        ->name("register.post");
    // LOGOUT ROUTE
    Route::get("logout", [AuthManager::class, "logout"])->name("logout");
    // PRODUCT ROUTES
    Route::get("/product/{slug}", [ProductsManager::class, "showDetails"])
        ->name("showDetails");
    Route::get('/load-more-products', [ProductsManager::class, 'loadMoreProducts'])
        ->name('loadMoreProducts');
    Route::get('/products', [ProductsManager::class,'index'])->name("recommended");
    Route::get('/products', [ProductsManager::class,'searchProduct'])
        ->name("search.product");
    Route::get('/products/category/{categoryId}', [ProductsManager::class,'showProductsByCategory'])
        ->name("search.category.product");

    Route::middleware("auth")->group(function(){
        //CART ROUTES
        Route::get('/cart/{id}/{quantity}', [CartManager::class, 'addToCart'])
        ->name('cart.add');
        Route::get('/remove_item/{id}', [CartManager::class, 'deleteFromCart'])
        ->name('cart.remove');
        Route::get('/add_quantity/{id}/{quantity}', [CartManager::class, 'updateQuantity'])
        ->name('add.quantity');
        Route::get("/cart", [CartManager::class, "showCart"])->name("cart.show");
        Route::get("/cart/number", [CartManager::class, "updateCartTotal"])->name("cart.item.number");

        //CHECKOUT ROUTES
        Route::get("/checkout", [OrderManager::class, "showCheckout"])
        ->name("checkout.show");
        Route::post("/checkout", [OrderManager::class, "checkoutPost"])
        ->name("checkout.post");

        //PAYMENT ROUTES
        Route::get('/payment/success/{order_id}', [OrderManager::class, 'paymentSuccess'])
            ->name('payment.success');
        Route::get('/payment/error', [OrderManager::class, 'paymentError'])
            ->name('payment.error');

        //ORDER ROUTES
        Route::get('/order-history/{status}', [OrderManager::class, 'orderHistory'])
            ->name('order.history');
        Route::get('/order-details/{id}', [OrderManager::class, 'orderDetails'])
            ->name('order.details');


});