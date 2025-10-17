<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware; // <--- pakai class langsung

// Login routes (tetap)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes yang dilindungi
Route::middleware(['auth'])->group(function () {
    // pakai class middleware langsung lalu tambahkan ":admin"
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware([RoleMiddleware::class . ':admin'])->name('admin.dashboard');

    // pakai class middleware langsung lalu tambahkan ":karyawan"
    Route::get('/karyawan/dashboard', function () {
        return view('karyawan.dashboard');
    })->middleware([RoleMiddleware::class . ':karyawan'])->name('karyawan.dashboard');
});
