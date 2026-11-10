<?php
// Paste these routes into your existing routes/web.php. Do not overwrite it.
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    // Temporary placeholder pages — replace each with your own controllers and views.
    foreach ([
        'orders' => 'Orders', 'products' => 'Products',
        'categories' => 'Categories', 'customers' => 'Customers',
        'reports' => 'Reports', 'discounts' => 'Discounts',
        'content' => 'Content', 'settings' => 'Settings',
    ] as $slug => $title) {
        Route::get("/{$slug}", fn () => view('admin.module', ['title' => $title]))->name($slug);
    }
});
// SECURITY: Before deploying, add admin authorization middleware or an admin Gate;
// auth alone does not prevent authenticated customers from entering admin pages.
