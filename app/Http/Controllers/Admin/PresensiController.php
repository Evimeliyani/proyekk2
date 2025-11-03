<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        // ambil map izin (approved) pada tanggal tsb
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

    // logika sama kayak index()
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

}
