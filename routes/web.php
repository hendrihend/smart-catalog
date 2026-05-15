<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk Merchant (Sudah Login) - Proteksi Middleware
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD Kategori menggunakan Resource Controller agar routing efisien
    Route::resource('categories', CategoryController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/', function () {
//     return view('welcome');
// });
