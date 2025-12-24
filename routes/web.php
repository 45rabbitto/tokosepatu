<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Authentication routes
Auth::routes();

// Dashboard (authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // UMKM routes
    Route::resource('umkm', UmkmController::class);
    
    // Product routes
    Route::resource('products', ProductController::class);
});

// Admin only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
});
