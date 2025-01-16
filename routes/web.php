<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\CartManager;
use App\Http\Controllers\CategoryManager;
use App\Http\Controllers\OrderManager;
use App\Http\Controllers\ProductsManager;
use App\Http\Controllers\UserManager;
use App\Models\Products;
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
    Route::get('home', [ProductsManager::class,'index'])->name("home");

    Route::get('/', [ProductsManager::class,'index'])->name("home");
    Route::get('shop', [ProductsManager::class,'showProducts'])->name("shop");
        
    // PRODUCT ROUTES
    Route::get("/product/{slug}", [ProductsManager::class, "showDetails"])
        ->name("showDetails");
    Route::get('/load-more-products', [ProductsManager::class, 'loadMoreProducts'])
        ->name('loadMoreProducts');
    Route::get('/products', [ProductsManager::class,'index'])->name("recommended");
    Route::get('/products/search/', [ProductsManager::class,'searchProduct'])
        ->name("search.product");
    Route::get('/products/category/{categoryId}', [ProductsManager::class,'showProductsByCategory'])
        ->name("search.category.product");
    
    Route::get("logout", [AuthManager::class, "logout"])->name("logout");

    Route::middleware("guest")->group(function(){
        
        //LOGIN ROUTES
        Route::get("login", [AuthManager::class, "login"])->name("login");

        Route::post("login", [AuthManager::class, "loginPost"])->name("login.post");
        // REGISTER ROUTES
        Route::get("register", [AuthManager::class, "registration"])->name("register");
        Route::post("register", [AuthManager::class, "registrationPost"])
            ->name("register.post");
        // LOGOUT ROUTE
        Route::get("forgot-password", [AuthManager::class, "forgotPassword"])->name("forgot.password");
      
        
        Route::get('/terms-and-conditions', function () {
            return view('pages.terms-and-conditions');
        })->name('terms-and-conditions');
        Route::get('/privacy-policy', function () {
            return view('pages.privacy-policy');
        })->name('privacy-policy');
        
    });

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

        //ADMIN ROUTES
        Route::get('dashboard', [AuthManager::class,'admin_Index'])->name("admin.dashboard");
        Route::get('admin/sales-revenue', [OrderManager::class, 'getSalesAndRevenue'])
        ->name('admin.getSalesAndRevenue');
        //ADMIN PRODUCTS
        Route::get('/products', [ProductsManager::class, 'getProducts'])->name('admin.products');
        Route::get('products/create',[ ProductsManager::class, 'showCreatePage'])
        ->name('admin.create.product');
        Route::post('products/create',[ProductsManager::class, 'create'])
        ->name('admin.product.create');
        Route::get('/product/edit/{id}',[ ProductsManager::class, 'showEditPage'])
        ->name('admin.edit.product');
        Route::put('admin/product/update/{id}', [ProductsManager::class, 'update'])
        ->name('admin.update.product');
        Route::put('/admin/product/inactivate/{id}', [ProductsManager::class, 'setInactiveProduct']);


        // CATEGORIES ROUTE
        Route::get('/category', [CategoryManager::class, 'index'])->name('admin.categories');
        Route::get('category/create',[ CategoryManager::class, 'showCreatePage'])
        ->name('admin.category.createpage');
        Route::post('category/create',[CategoryManager::class, 'create'])
        ->name('admin.create.category');
        Route::get('/category/edit/{id}',[ CategoryManager::class, 'showEditPage'])
        ->name('admin.edit.category');
        Route::put('admin/category/update/{id}', [CategoryManager::class, 'update'])
        ->name('admin.update.category');
        Route::put('/admin/categories/inactivate/{id}', [CategoryManager::class, 'setInactiveCategories']);
        
        Route::get('inventory', 
        function () {
                    return view("admin.products.inventory");
                })->name('admin.inventory');
              
        Route::get('bulk-upload', 
        function () {
                    return view("admin.products.bulk-upload");
                })->name('admin.bulk-upload');

        Route::get('users', [UserManager::class, 'index'])->name('admin.customers');
});