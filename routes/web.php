<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware;

// === Login routes ===
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// === Routes dengan proteksi auth ===
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware([RoleMiddleware::class . ':admin'])->name('admin.dashboard');

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
    Route::get('/izin/ajukan', fn() => 'Form Ajukan Izin')->name('izin.create');
    Route::get('/absensi/riwayat', fn() => 'Riwayat Absensi')->name('absensi.riwayat');
});
