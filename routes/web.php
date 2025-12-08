<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\LaporanController;

// === Login routes ===
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// === Routes dengan proteksi auth ===
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])
    ->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

    // Menu admin lain (sementara pakai view sederhana/placeholder agar tidak error)
        Route::get('/admin/karyawan', [KaryawanController::class,'index'])->name('admin.karyawan.index');
        Route::get('/admin/karyawan/tambah', [KaryawanController::class,'create'])->name('admin.karyawan.create');
        Route::post('/admin/karyawan',       [KaryawanController::class,'store'])->name('admin.karyawan.store');
        Route::get('/admin/karyawan/{user}/edit', [KaryawanController::class,'edit'])->name('admin.karyawan.edit');
        Route::put('/admin/karyawan/{user}',      [KaryawanController::class,'update'])->name('admin.karyawan.update');
        Route::delete('/admin/karyawan/{user}',   [KaryawanController::class,'destroy'])->name('admin.karyawan.destroy');

        Route::get('/admin/presensi', [PresensiController::class, 'index'])->name('admin.presensi.index');
        Route::get('/admin/presensi/cetak', [PresensiController::class, 'cetak'])->name('admin.presensi.cetak');
        
        Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');


        // Persetujuan izin (daftar + approve/reject)
        Route::get('/admin/izin', [IzinController::class, 'index'])->name('izin.index');
        Route::post('/admin/izin/{izin}/approve', [IzinController::class, 'approve'])->name('izin.approve');
        Route::post('/admin/izin/{izin}/reject',  [IzinController::class, 'reject'])->name('izin.reject');
        
    });


Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':karyawan'])->group(function () {
    // Karyawan dashboard
    Route::get('/karyawan/dashboard', function () {
        // di sini kamu bisa lempar data ke view dashboard
        $attendance = [
            'Jan' => 90, 'Feb' => 88, 'Mar' => 86, 'Apr' => 84,
            'Mei' => 82, 'Jun' => 80, 'Jul' => 78, 'Agu' => 76,
            'Sep' => 74, 'Okt' => 72, 'Nov' => 70, 'Des' => 68,
        ];
        $info = '<ul style="margin:0;padding-left:18px">
                   <li>Jam kerja: 08:00–17:00</li>
                   <li>Batas ajukan izin H-1 (kecuali darurat)</li>
                 </ul>';

        return view('karyawan.dashboard', compact('attendance','info'));
    })->middleware([RoleMiddleware::class . ':karyawan'])->name('karyawan.dashboard');

    // Contoh route dummy untuk menu di dashboard
  
    Route::get('/izin/ajukan', [IzinController::class, 'create'])->name('izin.create');
    Route::post('/izin/ajukan', [IzinController::class, 'store'])->name('izin.store');
    Route::get('/izin/sukses/{izin}', [IzinController::class, 'success'])->name('izin.sukses'); // opsional

    Route::get('/absensi/riwayat', [AbsensiController::class, 'index'])
    ->middleware([\App\Http\Middleware\RoleMiddleware::class . ':karyawan'])
    ->name('absensi.riwayat');
});

    // ==============================
// ROUTE UNTUK AMBIL UID DARI ESP32
// ==============================

Route::get('/scan-presensi', [PresensiController::class, 'scanRealtime'])
     ->name('scan.presensi');


// ==============================
// ROUTE UNTUK PROSES ABSENSI
// ==============================
Route::get('/absensi/proses', [AbsensiController::class, 'proses'])
     ->name('absensi.proses');

