<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatAbsensiController extends Controller
{
    public function index()
    {
        // Catatan: Karena data absensi sudah disimulasikan di dalam file Blade 
        // menggunakan blok @php (untuk memudahkan copy-paste Anda), 
        // kita hanya perlu memanggil view-nya.
        // Di aplikasi nyata, Anda akan mengambil data dari Model (database) di sini.
        
        return view('riwayat_absensi');
    }
}