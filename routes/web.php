
<?php

use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

// Shared customer and admin login/logout
require __DIR__ . '/auth-login.php';

// Customer website routes
// Homepage, Shop, and Cart
require __DIR__ . '/storefront.php';

// Customer account page
Route::view('/account', 'pages.account')
    ->middleware('auth')
    ->name('account');

// Admin routes: authentication + admin role required
Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        require __DIR__ . '/admin-example.php';

    });
