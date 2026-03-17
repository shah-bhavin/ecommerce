<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

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
});

