
<?php

use Illuminate\Support\Facades\Route;

// Admin Dashboard
Route::redirect('/', '/admin/dashboard');

Route::view('/dashboard', 'admin.dashboard')
    ->name('dashboard');

// Admin module pages
$modules = [
    'orders' => 'Orders',
    'products' => 'Products',
    'categories' => 'Categories',
    'customers' => 'Customers',
    'reports' => 'Reports',
    'discounts' => 'Discounts',
    'content' => 'Content',
    'settings' => 'Settings',
];

foreach ($modules as $slug => $title) {
    Route::get("/{$slug}", function () use ($title) {
        return view('admin.module', [
            'title' => $title
        ]);
    })->name($slug);
}
