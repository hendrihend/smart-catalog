<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk Merchant Resmi (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * SANGAT PENTING (SOLUSI ERROR):
     * Letakkan route '/products/export/excel' di ATAS Route::resource('products').
     * Jika ditaruh di bawah, kata 'export' akan dianggap sebagai ID produk oleh Laravel 
     * dan akan memicu error "Call to undefined method ProductController::show()".
     */
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export');

    // Route Resource CRUD Kategori
    Route::resource('categories', CategoryController::class);

    // Route Resource CRUD Produk - Kita batasi agar tidak mendaftarkan rute 'show' jika memang tidak dipakai
    Route::resource('products', ProductController::class)->except(['show']);
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});