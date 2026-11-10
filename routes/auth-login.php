
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Shared login page
Route::get('/login', [
    AuthenticatedSessionController::class,
    'create'
])->name('login');

// Process login
Route::post('/login', [
    AuthenticatedSessionController::class,
    'store'
])->middleware('throttle:6,1');

// Logout
Route::post('/logout', [
    AuthenticatedSessionController::class,
    'destroy'
])->middleware('auth')->name('logout');
