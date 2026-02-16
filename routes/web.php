<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DiscountController;



// Frontend Controllers
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\CategoryController as FrontCategoryController;
use App\Http\Controllers\Front\OrderController as FrontOrderController;
use App\Http\Controllers\Front\WishlistController as FrontWishlistController;
use App\Http\Controllers\Front\AboutController as FrontAboutController;
use App\Http\Controllers\Front\ContactController as FrontContactController;
use App\Http\Controllers\Front\CheckoutController as FrontCheckoutController;
// use App\Http\Controllers\Front\CartController as FrontCartController;
/*
|--------------------------------------------------------------------------
| Frontend Public Routes (Customer-facing)
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontHomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/product/{product}', [FrontProductController::class, 'show'])->name('product.show');
Route::get('/category', [FrontCategoryController::class, 'index'])->name('category.index');
Route::get('/category/{category}', [FrontCategoryController::class, 'show'])->name('category.show');
Route::get('/order', [FrontOrderController::class, 'index'])->name('order.index');
Route::get('/about', [FrontAboutController::class, 'index'])->name('about.index');
Route::get('/contact', [FrontContactController::class, 'index'])->name('contact.index');
Route::get('/cart', [FrontProductController::class, 'cart'])->name('front.cards.index');
Route::post('/cart/add', [FrontProductController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{productId}', [FrontProductController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [FrontProductController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear', [FrontProductController::class, 'clearCart'])->name('cart.clear');
Route::get('/checkout', [FrontCheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [FrontCheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/thank-you/{order_number}', [FrontCheckoutController::class, 'thankYou'])->name('checkout.thank-you');
// discounts
Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
Route::post('/coupon/apply', [FrontCheckoutController::class, 'applyCoupon'])->name('coupon.apply');
Route::post('/coupon/remove', [FrontCheckoutController::class, 'removeCoupon'])->name('coupon.remove');

/*
|--------------------------------------------------------------------------
| Pages The WebSite for the Elctronic Stoer 
|--------------------------------------------------------------------------
*/
Route::resource('pages', PagesController::class);


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes();


Route::middleware('auth')->group(function () {


    Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('password.change');


    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('password.update');
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('setting.update');
});

/*
|--------------------------------------------------------------------------
| Dashboard + Admin Panel (Super Admin + Sub Admin)
| role_id = 1 or 2
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1,2'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategorieController::class);
    // Route::put('categories/{category}', [CategorieController::class, 'update'])
    //     ->name('categories.update');
    // Products
    Route::resource('products', ProductController::class);
    Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])
        ->name('products.images.delete');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    //Coupons
    Route::resource('discounts', DiscountController::class)
        ->names('admin.coupons')
        ->parameters(['discounts' => 'coupon']);
    Route::patch('discounts/{discount}/toggle', [DiscountController::class, 'toggle'])
        ->name('admin.discounts.toggle');

    // Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');

    // wishlist


    Route::get('/wishlist', [FrontWishlistController::class, 'index'])->name('wishlist.index');


    Route::post('/wishlist', [FrontWishlistController::class, 'store'])->name('wishlist.store');


    Route::delete('/wishlist/clear', [FrontWishlistController::class, 'clear'])->name('wishlist.clear');


    Route::delete('/wishlist/{product_id}', [FrontWishlistController::class, 'destroy'])->name('wishlist.destroy');


    Route::post('/wishlist/{product}/move-to-cart', [FrontWishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
    Route::post('/wishlist/move-all-to-cart', [FrontWishlistController::class, 'moveAllToCart'])->name('wishlist.moveAllToCart');
});

/*
|--------------------------------------------------------------------------
|Brands Routes
|--------------------------------------------------------------------------
*/
// صفحة عرض كل الماركات (للمستخدم)
Route::get('/brands', [BrandController::class, 'index'])
    ->name('brands.index');

// صفحة عرض ماركة واحدة باستخدام slug
Route::get('/brands/{brand:slug}', [BrandController::class, 'show'])
    ->name('brands.show');

Route::prefix('dsadmin')->name('dsadmin.')->group(function () {

    // عرض كل الماركات (admin)
    Route::get('/brands', [BrandController::class, 'index'])
        ->name('brands.index');

    // create
    Route::get('/brands/create', [BrandController::class, 'create'])
        ->name('brands.create');

    // store
    Route::post('/brands', [BrandController::class, 'store'])
        ->name('brands.store');

    // edit
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])
        ->name('brands.edit');

    // update
    Route::put('/brands/{brand}', [BrandController::class, 'update'])
        ->name('brands.update');

    // delete
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])
        ->name('brands.destroy');

    // toggle visibility
    Route::get('/brands/{brand}/toggle', [BrandController::class, 'toggleVisibility'])
        ->name('brands.toggle');
});

/*
|--------------------------------------------------------------------------
| Super Admin Only (Manage Admins)
| role_id = 1 فقط
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1'])->group(function () {

    // Super Admins (role_id = 1)
    Route::get('super-admins', [AdminUsersController::class, 'indexSuper'])->name('super-admins.index');
    Route::get('super-admins/create', [AdminUsersController::class, 'createSuper'])->name('super-admins.create');
    Route::post('super-admins', [AdminUsersController::class, 'storeSuper'])->name('super-admins.store');
    Route::get('super-admins/{user}/edit', [AdminUsersController::class, 'editSuper'])->name('super-admins.edit');
    Route::put('super-admins/{user}', [AdminUsersController::class, 'updateSuper'])->name('super-admins.update');
    Route::delete('super-admins/{user}', [AdminUsersController::class, 'destroySuper'])->name('super-admins.destroy');

    // Sub Admins (role_id = 2)
    Route::get('sub-admins', [AdminUsersController::class, 'indexSub'])->name('sub-admins.index');
    Route::get('sub-admins/create', [AdminUsersController::class, 'createSub'])->name('sub-admins.create');
    Route::post('sub-admins', [AdminUsersController::class, 'storeSub'])->name('sub-admins.store');
    Route::get('sub-admins/{user}/edit', [AdminUsersController::class, 'editSub'])->name('sub-admins.edit');
    Route::put('sub-admins/{user}', [AdminUsersController::class, 'updateSub'])->name('sub-admins.update');
    Route::delete('sub-admins/{user}', [AdminUsersController::class, 'destroySub'])->name('sub-admins.destroy');
});

Route::get('locale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    // Explicitly save to session
    session(['locale' => $locale]);
    session()->save();

    // Debugging (optional, remove in production if valid)
    // \Log::info("Switched locale to: " . $locale);

    return redirect()->back(); // Or redirect('/');
})->name('locale.switch');
