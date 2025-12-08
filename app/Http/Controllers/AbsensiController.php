<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // ==========================
    // RIWAYAT ABSENSI (karyawan)
    // ==========================
    public function index(Request $request)
    {
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


    // ========================================
    // FUNGSI BARU: PROSES ABSENSI DARI ESP32
    // ========================================
    public function proses()
    {
        // IP ESP32 (ganti sesuai IP kamu)
        $esp32_ip = "http://172.20.10.2/rfid-scan";


        // Ambil data UID dari ESP32
        $response = @file_get_contents($esp32_ip);

        if (!$response) {
            return "Gagal menghubungi perangkat RFID";
        }

        $data = json_decode($response, true);
        $uid  = strtoupper($data['uid'] ?? '');

        if ($uid == "") {
            return "Tidak ada UID diterima";
        }

        // Cek apakah UID terdaftar
        $user = User::where('uid', $uid)->first();

        if (!$user) {
            return "Kartu tidak terdaftar";
        }

        // Cek sudah absen hari ini
        $sudah = Absensi::where('user_id', $user->id)
                        ->whereDate('tanggal', now()->toDateString())
                        ->exists();

        if ($sudah) {
            return "Sudah absen hari ini";
        }

        // Simpan data absensi
        Absensi::create([
            'user_id' => $user->id,
            'uid'     => $uid,
            'tanggal' => now(),
        ]);

        return "Absen berhasil untuk: " . $user->name;
    }
}
