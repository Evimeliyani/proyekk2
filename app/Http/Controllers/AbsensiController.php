<?php

// app/Http/Controllers/AbsensiController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // default = bulan & tahun saat ini
        $month = (int)($request->query('month', now()->month));
        $year  = (int)($request->query('year',  now()->year));

        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end   = (clone $start)->endOfMonth()->endOfDay();

        $riwayat = Absensi::with('user')
            ->where('user_id', auth()->id())
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get();

        $labelBulan = $start->translatedFormat('F Y');

        return view('karyawan.absensi.riwayat', compact('riwayat','month','year','labelBulan'));
    }
}

