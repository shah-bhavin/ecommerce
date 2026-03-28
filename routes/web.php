<?php

use Illuminate\Support\Facades\Route;
//Route::view('/', 'welcome')->name('home');

// Route::livewire('/', 'store.home')->name('home');
// Route::livewire('/shop', 'store.shop-index')->name('shop');
// Route::livewire('/product/{slug}', 'store.product-show')->name('product.show');

// Frontend Routes (All pointing to Livewire SFCs)
Route::livewire('/', 'store.home')->name('home');
Route::livewire('/collection/{category?}', 'store.shop')->name('shop');
Route::livewire('/product/{slug}', 'store.product-detail')->name('product.show');
Route::livewire('/cart', 'store.cart')->name('cart');
Route::livewire('/checkout', 'store.checkout')->name('checkout');
Route::livewire('/search', 'store.search')->name('search');
Route::livewire('/thank-you', 'store.thank-you')->name('thank-you');
//Route::livewire('/wishlist', 'shop.wishlist')->name('wishlist');

// Route::middleware('guest')->group(function () {
//     Route::livewire('/login', 'store.auth.login')->name('login');
//     Route::livewire('/register', 'store.auth.register')->name('register');
// });

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// --- AUTH CUSTOMERS ---
Route::middleware('auth')->group(function () {
    Route::livewire('/account/{view?}', 'store.account.dashboard')->name('account');

    //Route::livewire('/account', 'store.account.dashboard');
    Route::livewire('/account/orders', 'store.account.orders');
    Route::livewire('/account/orders/{id}', 'store.account.track-order'); // Track Order
    Route::livewire('/account/profile', 'store.account.profile');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::middleware(['auth', 'verified'])->prefix('/admin')->group(function () {
    Route::livewire('/categories', 'admin.categories')->name('admin.categories');
    Route::livewire('/brands', 'admin.brands')->name('admin.brands');
    Route::livewire('/products', 'admin.products')->name('admin.products');
    Route::livewire('/coupons', 'admin.coupons')->name('admin.coupons');
    Route::livewire('/users', 'admin.users')->name('admin.users');
    Route::livewire('/addresses', 'admin.addresses')->name('admin.addresses');
    Route::livewire('/orders', 'admin.orders')->name('admin.orders');
    Route::livewire('/wishlists', 'admin.wishlist')->name('admin.wishlist');
    Route::livewire('/reviews', 'admin.reviews')->name('admin.reviews');
    Route::livewire('/carousel', 'admin.carousel')->name('admin.carousel');
});

// --- CUSTOMER AUTH ---
Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'store.auth.login')->name('login');
    Route::livewire('/register', 'store.auth.register')->name('register');
});

// --- ADMIN AUTH ---
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::livewire('/login', 'admin.auth.login')->name('admin.login');
    });
    
    // Protected Admin Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::livewire('/dashboard', 'admin.categories')->name('admin.dashboard');
    });
});



/********************************Suggested ********************************/
// Route::get('/', 'store.home')->name('home');
// Route::get('/shop', 'store.shop')->name('shop');

// Route::get('/account', 'store.account.index')->name('account'); // Smart Login/Profile
// Route::get('/register', 'store.auth.register')->name('register');

// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
//     Route::get('/carousels', 'admin.carousel.index')->name('admin.carousels');
// });
/********************************Suggested ********************************/
