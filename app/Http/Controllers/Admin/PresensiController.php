<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
use Carbon\Carbon;

class PresensiController extends Controller
{

    public function index(Request $request)
    {
        // tanggal dipilih admin (default hari ini)
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        // ambil semua karyawan + profil
        $users = User::where('role','karyawan')->with('karyawan')->get();

        // ambil map absensi pada tanggal tsb
        $absensiMap = Absensi::whereDate('tanggal',$tanggal)
            ->get()
            ->keyBy('user_id');

        // ambil map izin (approved)
        $izinMap = Izin::whereDate('tanggal_izin',$tanggal)
            ->where('status','approved')
            ->get()
            ->keyBy('user_id');

        // susun baris tabel
        $rows = $users->map(function($u) use ($absensiMap,$izinMap){
            $abs = $absensiMap->get($u->id);
            $izin = $izinMap->get($u->id);

            if ($abs) {
                $jam = $abs->jam_masuk ? $abs->jam_masuk->format('H : i') : '-';
                $status = ucfirst($abs->status);
            } else {
                if ($izin) { $jam='-'; $status='Izin'; }
                else       { $jam='-'; $status='Alfa'; }
            }

            return [
                'uid'   => $u->karyawan->uid ?? '-',
                'nama'  => $u->name,
                'jam'   => $jam,
                'status'=> $status,
            ];
        });

        return view('admin.presensi.index', [
            'tanggal' => $tanggal,
            'rows'    => $rows,
        ]);
    }

    public function cetak(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        // logika sama seperti index
        $users = User::where('role','karyawan')->with('karyawan')->get();
        $absensiMap = Absensi::whereDate('tanggal',$tanggal)->get()->keyBy('user_id');
        $izinMap = Izin::whereDate('tanggal_izin',$tanggal)
            ->where('status','approved')
            ->get()
            ->keyBy('user_id');

        $rows = $users->map(function($u) use ($absensiMap,$izinMap){
            $abs = $absensiMap->get($u->id);
            $izin = $izinMap->get($u->id);

            if ($abs) {
                $jam = $abs->jam_masuk ? \Carbon\Carbon::parse($abs->jam_masuk)->format('H : i') : '-';
                $status = ucfirst($abs->status ?? 'Hadir');
            } else {
                if ($izin) { $jam='-'; $status='Izin'; }
                else       { $jam='-'; $status='Alfa'; }
            }

            return [
                'uid'   => $u->karyawan->uid ?? '-',
                'nama'  => $u->name,
                'jam'   => $jam,
                'status'=> $status,
            ];
        });

        return view('admin.presensi.cetak', [
            'tanggal' => $tanggal,
            'rows'    => $rows,
        ]);
    }



    // ============================================
    //  ✨ FUNGSI BARU UNTUK REALTIME RFID
    // ============================================
    public function scanRealtime()
{
    // IP ESP32 kamu
    $esp32_ip = "http://10.0.175.16/rfid-scan";

    try {
        $response = Http::timeout(2)->get($esp32_ip);
    } catch (\Exception $e) {
        return [
            'uid'    => '',
            'status' => 'ESP32 offline',
        ];
    }

    $data = $response->json();
    $uid  = $data['uid'] ?? '';

    // kalau ESP belum kirim UID apa-apa
    if ($uid === '') {
        return [
            'uid'    => '',
            'status' => 'kosong',
        ];
    }

    // cari karyawan berdasarkan UID
    $karyawan = User::whereHas('karyawan', function ($q) use ($uid) {
        $q->where('uid', $uid);
    })->first();

    if (! $karyawan) {
        return [
            'uid'    => $uid,
            'status' => 'UID tidak terdaftar',
        ];
    }

    // ====== PAKAI WIB (Asia/Jakarta) ======
    $now      = Carbon::now('Asia/Jakarta');   // ← kuncinya di sini!
    $jamMasuk = $now->format('H:i:s');

    // batas terlambat: 08:00 WIB
    $batasTerlambat = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');

    if ($now->greaterThan($batasTerlambat)) {
        $status = 'terlambat';
    } else {
        $status = 'hadir';
    }

    // simpan / update absensi hari ini
    Absensi::updateOrCreate(
        [
            'user_id' => $karyawan->id,
            'tanggal' => $now->toDateString(),
        ],
        [
            'jam_masuk' => $jamMasuk,
            'status'    => $status,
        ]
    );

    return [
        'uid'    => $uid,
        'status' => $status,   // 'hadir' atau 'terlambat'
        'nama'   => $karyawan->name,
        'jam'    => $jamMasuk, // biar kelihatan juga di console kalau mau
    ];
}
}
