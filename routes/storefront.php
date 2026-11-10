<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\StorefrontController;

Route::name('storefront.')->group(function () {

    Route::get('/', [StorefrontController::class, 'home'])
        ->name('home');

    Route::get('/shop', [StorefrontController::class, 'shop'])
        ->name('shop');

    Route::get('/cart', [StorefrontController::class, 'cart'])
        ->name('cart');

    Route::post('/cart/add', [StorefrontController::class, 'addToCart'])
        ->name('cart.add');

    Route::patch('/cart', [StorefrontController::class, 'updateCart'])
        ->name('cart.update');
});