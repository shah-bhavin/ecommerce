<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Frontend Routes (All pointing to Livewire SFCs)
Route::livewire('/', 'store.home')->name('home');
Route::livewire('/shop/{category?}', 'store.shop')->name('shop');
Route::livewire('/about', 'store.about')->name('about');
Route::livewire('/contact', 'store.contact')->name('contact');
Route::livewire('/product/{slug}', 'store.product-detail')->name('product.show');
Route::livewire('/cart', 'store.cart')->name('cart');

Route::middleware('auth')->group(function () {
    Route::livewire('/checkout', 'store.checkout')->name('checkout');
    Route::livewire('/search', 'store.search')->name('search');
    Route::livewire('/thanks/{orderid?}', 'store.thanks')->name('thanks');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('custom.logout');

// --- AUTH CUSTOMERS ---
Route::middleware('auth', 'customer')->group(function () {
    Route::livewire('/account/{view?}', 'store.account.dashboard')->name('account');
    Route::livewire('/account/orders', 'store.account.orders');
    Route::livewire('/account/orders/{id}', 'store.account.track-order'); // Track Order
    Route::livewire('/account/profile', 'store.account.profile');
});

require __DIR__.'/settings.php';

Route::middleware(['auth', 'verified', 'admin'])->prefix('/admin')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
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
    Route::livewire('/shipping', 'admin.shipping-rules')->name('admin.shipping');
});

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'store.auth.login')->name('login');
    Route::livewire('/register', 'store.auth.register')->name('register');
    Route::livewire('/forgot-password', 'store.auth.forgot-password')->name('forgot-password');
});

Route::prefix('/admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::view('/', 'auth.login')->name('admin.login');
        Route::view('/register', 'auth.register')->name('admin.register');
    });
});