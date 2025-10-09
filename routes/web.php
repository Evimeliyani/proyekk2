<?php
// routes/web.php

use App\Http\Controllers\Auth\LoginPresensiController;
// Tambahkan Controller baru di sini
use App\Http\Controllers\QRCodeController; 
use App\Http\Controllers\AbsensiController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Rute Login, yang menampilkan form login ---
Route::get('/login-presensi', [LoginPresensiController::class, 'showLoginForm'])->name('presensi.login');
// POST: Memproses data login
Route::post('/login-presensi', [LoginPresensiController::class, 'login']);

// --- Rute yang Membutuhkan Autentikasi ---
Route::middleware('auth:web')->group(function () {
    
    
    // Rute Logout
    Route::post('/logout', [LoginPresensiController::class, 'logout'])->name('logout');
    
    // 1. DASHBOARD ADMIN
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->status != 'admin') {
            return redirect('/karyawan/dashboard'); 
        }
        // Ganti dengan view dashboard admin Anda
        return view('admin.dashboard'); 
    })->name('admin.dashboard');

    // 2. DASHBOARD KARYAWAN
    Route::get('/karyawan/dashboard', function () {
        if (Auth::user()->status != 'karyawan') {
            return redirect('/admin/dashboard'); 
        }
        // View ini akan memuat file karyawan/dashboard.blade.php
        return view('karyawan.dashboard'); 
    })->name('karyawan.dashboard');

    // --- Rute Menu Karyawan ---

    
    // Rute API untuk MENGHASILKAN GAMBAR QR CODE DINAMIS
    Route::get('/api/qr/generate', [QRCodeController::class, 'generate'])
         ->name('api.qr.generate');
    
    // Menampilkan halaman Pengajuan Izin
    Route::get('/izin', function () {
        // Ganti dengan view pengajuan izin Anda
        return view('karyawan.izin'); 
    })->name('karyawan.izin'); 
    
    // Menampilkan halaman Riwayat Absensi
    Route::get('/riwayat_absensi', function () {
        return view('karyawan.riwayat');
    })->name('karyawan.riwayat');
    

});
