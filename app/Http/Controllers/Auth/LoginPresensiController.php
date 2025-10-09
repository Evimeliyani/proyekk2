<?php
// app/Http/Controllers/Auth/LoginPresensiController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi; // Import Model Presensi

class LoginPresensiController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('login'); 
    }

    /**
     * Handle proses login dengan verifikasi manual (mengabaikan hashing).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Cari Pengguna Secara Manual
        $user = Presensi::where('email', $credentials['email'])->first();

        // 2. Verifikasi Password Secara Manual (HANYA UNTUK TUGAS/DEBUGGING)
        // Kita bandingkan password yang diketik dengan password yang kita simpan di database (sebagai teks MENTAH)
        
        // --- Cek Kredensial Karyawan/Admin ---
        // Jika user ditemukan DAN password yang diketik SAMA DENGAN password di database
        if ($user && $credentials['password'] === $user->password) { 
            
            // --- PAKSA LOGIN SUKSES ---
            Auth::login($user);
            $request->session()->regenerate();
            
            // 3. Logika Pengalihan Dashboard
            if ($user->status === 'admin') {
                return redirect()->intended('/admin/dashboard'); 
            } 
            
            if ($user->status === 'karyawan') {
                return redirect()->intended('/karyawan/dashboard'); 
            }

            // Default
            return redirect()->intended('/'); 
        }

        // 4. Jika Gagal Login
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}