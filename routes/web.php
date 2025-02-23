<?php

use App\Http\Controllers\AddressManager;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartManager;
use App\Http\Controllers\CategoryManager;
use App\Http\Controllers\InventoryLogManager;
use App\Http\Controllers\OrderManager;
use App\Http\Controllers\OrderTrackingManager;
use App\Http\Controllers\ProductsManager;
use App\Http\Controllers\ProductVariantManager;
use App\Http\Controllers\ReviewsManager;
use App\Http\Controllers\ShippingOptionController;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\WishlistManager;
use App\Models\Products;
use App\Models\ProductVariant;
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
        Route::get("forgot-password-otp", function(){
            return view('auth.forgot-password-otp');
        })->name("forgot.password.otp");

        
        Route::get('/terms-and-conditions', function () {
            return view('pages.terms-and-conditions');
        })->name('terms-and-conditions');
        Route::get('/privacy-policy', function () {
            return view('pages.privacy-policy');
        })->name('privacy-policy');
        
    });

    Route::middleware("auth")->group(function(){
        //CART ROUTES
        Route::post('cart/', [CartManager::class, 'addToCart'])
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

        // MY ACCOUNT
        Route::get('profile',[UserManager::class, 'profile'])->name('user.profile');
        Route::put('/update/profile', [UserManager::class, 'update'])
        ->name('profile.update');
        Route::put('/update/password', [UserManager::class, 'updatePassword'])
        ->name('user.update.password');

        Route::post('/create/address', [AddressManager::class, 'store'])
        ->name('user.create.address');
        Route::delete('delete/address', [AddressManager::class, 'destroy'])
        ->name('delete.address');
        Route::put('update/address', [AddressManager::class, 'update'])
        ->name('update.address');

        //Wishlist 
        Route::get('wishlist',[WishlistManager::class, 'show'])
        ->name('user.wishlist');
        Route::delete('delete/user/wishlist', [WishlistManager::class, 'userRemoveWishlist'])
        ->name('delete.user.wishlist');
        Route::post('/move-to-cart', [WishlistManager::class, 'moveToCart'])
        ->name('wishlist.move.to.cart');
        Route::post('add/wishlist', [WishlistManager::class, 'store'])
        ->name('add.wishlist');
        Route::delete('delete/wishlist', [WishlistManager::class, 'destroy'])
        ->name('delete.wishlist');
        // Route::get('/wishlist/number', [WishlistManager::class, ''])->name('wishlist.item.number');


        Route::get('change-password', function(){
            return view('user.account.change-password');
        })->name('user.change-password');


        Route::post('product-review/store',[ReviewsManager::class, 'store'])
        ->name('store.product.review');

        


        //ORDER ROUTES
        Route::get('/order-history', [OrderManager::class, 'orderHistory'])
            ->name('order.history');
        Route::get('/order-details/{id}', [OrderManager::class, 'orderDetails'])
            ->name('order.details');
        Route::get('/order-tracking/{orderId}', [OrderTrackingManager::class, 'orderTracking'])
        ->name('user.order.tracking');
        

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
        Route::put('admin/update/selected/products', [ProductsManager::class, 'bulkUpdate'])
        ->name('admin.update.selected.products');
        
        //PRODUCT VARIANT 
        Route::post('admin/create/variant', [ProductVariantManager::class, 'create'])
        ->name('admin.create.variant');
        Route::put('admin/update/variant', [ProductVariantManager::class, 'update'])
        ->name('admin.update.variant');
        Route::delete('admin/delete/variant/{id}', [ProductVariantManager::class, 'destroy'])
        ->name('admin.delete.variant');

       

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

        // BRANDS ROUTE
        Route::get('/brands', [BrandController::class, 'index'])
        ->name('admin.brands');
        Route::get('brands/create',[BrandController::class,'showCreatePage'])
        ->name('admin.brand.createpage');
        Route::post('/api/brands/create',[BrandController::class,'create'])
        ->name('admin.create.brand');
        Route::get('/brand/edit/{id}', [BrandController::class, 'showEditPage'])
        ->name('admin.edit.brand');
        Route::put('/api/brands/update/{id}', [BrandController::class, 'update'])
        ->name('admin.update.brand');
        Route::put('/admin/brand/inactivate/{id}', [BrandController::class, 'setInactiveBrand']);
        
        // ORDERS ROUTE
        Route::get('/orders',[OrderManager::class, 'index'])->name('admin.orders');
        Route::get('/orders/{id}',[OrderManager::class, 'showOrderDetails'])
        ->name('admin.orders.details');
        Route::put('/orders/update/{id}',[OrderManager::class, 'update'])
        ->name('admin.orders.update');
        Route::put('admin/orders/status-Update', [OrderManager::class, 'statusUpdate'])
        ->name('admin.orders.orderStatus');



        // INVENTORY ROUTE
        Route::get('inventory', [InventoryLogManager::class, 'index'])
        ->name('admin.inventory.inventory_logs');
        Route::put('api/inventory/update', [InventoryLogManager::class, 'store'])
        ->name("admin.inventory.stock.update");


        // SHIPPING ROUTE
        Route::get('shipping', [ShippingOptionController::class, 'show'])
        ->name('admin.shipping');

        Route::get('shipping/edit/{id}', [ShippingOptionController::class, 'showEditPage'])
        ->name('admin.shipping.edit');
        Route::put('/shipping/update', [ShippingOptionController::class, 'update'])
        ->name('admin.shipping.update');

        Route::get('shipping/create', [ShippingOptionController::class, 'showCreatePage'])
        ->name('admin.shipping.create');
        Route::post('shipping/store',[ShippingOptionController::class, 'store'])->name('admin.shipping.store');
        Route::put('shipping/delete', [ShippingOptionController::class, 'destroy'])
        ->name('admin.shipping.delete');


        Route::get('bulk-upload', 
        function () {
                    return view("admin.products.bulk-upload");
                })->name('admin.bulk-upload');

        Route::get('users', [UserManager::class, 'index'])->name('admin.customers');
});