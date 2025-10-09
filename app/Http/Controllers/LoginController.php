<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi; // Pastikan Model Presensi di-import

class LoginController extends Controller
{
    // Menampilkan halaman login (GET /login)
    public function showLoginForm()
    {
        // Ganti 'login' dengan nama view Anda: 'login' jika disimpan di resources/views/login.blade.php
        return view('login'); 
    }

    // Memproses permintaan login (POST /login-presensi)
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Catatan: Input 'name_tampilan' tidak digunakan dalam proses Auth.

        // 2. Proses Autentikasi
        // Gunakan Auth::attempt() untuk mencoba login
        if (Auth::attempt($credentials)) {
            // Login berhasil
            $request->session()->regenerate();

            // Arahkan ke dashboard setelah login
            // Sesuaikan nama rute jika dashboard Anda memiliki nama rute lain
            return redirect()->intended('/dashboard'); 
        }

        // 3. Login Gagal
        // Kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau Password tidak valid.',
        ])->onlyInput('email');
    }
    
    // Fungsi Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Kembali ke halaman utama atau login
    }
}