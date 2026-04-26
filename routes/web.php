<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

// tampilan utama saat mengakses halaman
Route::get('/', [ProductController::class, 'landing'])->name('landing');


// autentikasi user (login, register, logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



// route chart untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
});


// route admin untuk mengelola produk dan kategori, hanya bisa diakses oleh user dengan role admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // route untuk menampilkan daftar produk di halaman admin index
    Route::get('/', [ProductController::class, 'index'])->name('admin.index');

    // route untuk menampilkan form tambah produk dan menyimpan produk baru di halaman admin
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.store');

    // route untuk menampilkan form edit produk, memperbarui produk, dan menghapus produk di halaman admin
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.update');

    // route untuk menghapus produk di halaman admin
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.destroy');

    // route untuk mengelola kategori produk di halaman admin
    Route::resource('categories', CategoryController::class);
});