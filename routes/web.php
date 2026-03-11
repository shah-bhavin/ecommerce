<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::livewire('/admin/categories', 'admin.categories')->name('admin.categories');
Route::livewire('/admin/brands', 'admin.brands')->name('admin.brands');
Route::livewire('/admin/products', 'admin.products')->name('admin.products');
Route::livewire('/admin/coupons', 'admin.coupons')->name('admin.coupons');
Route::livewire('/admin/users', 'admin.users')->name('admin.users');
Route::livewire('/admin/addresses', 'admin.addresses')->name('admin.addresses');
Route::livewire('/admin/orders', 'admin.orders')->name('admin.orders');
Route::livewire('/admin/wishlist', 'admin.wishlist')->name('admin.wishlist');

