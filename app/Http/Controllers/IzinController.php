<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;
use App\Models\Absensi;
use Carbon\Carbon;

class IzinController extends Controller
{
    /**
     * FORM AJUKAN IZIN (KARYAWAN)
     * GET /izin/ajukan
     */
    public function create()
    {
        return view('izin.create'); // resources/views/izin/create.blade.php
    }

    /**
     * SIMPAN PENGAJUAN IZIN (KARYAWAN)
     * POST /izin/ajukan
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_izin' => ['required','date'],
            'jenis_izin'   => ['required','string','max:100'],
            'alasan'       => ['required','string','max:255'],
        ]);

        $izin = Izin::create([
            'user_id'      => Auth::id(),
            'tanggal_izin' => $request->tanggal_izin,
            'jenis_izin'   => $request->jenis_izin,
            'alasan'       => $request->alasan,
            'status'       => 'pending', // pending | approved | rejected
        ]);

        // pilih salah satu:
        // return view('izin.sukses', compact('izin'));
        return redirect()->route('izin.sukses', $izin->id);
    }

    /**
     * HALAMAN SUKSES (KARYAWAN)
     * GET /izin/sukses/{izin}
     */
    public function success(Izin $izin)
    {
        // pastikan hanya pemilik pengajuan yang bisa lihat
        abort_if($izin->user_id !== Auth::id(), 403);
        return view('izin.sukses', compact('izin'));
    }

    // ---------------------------------------------------------------------
    //                              ADMIN
    // ---------------------------------------------------------------------

    /**
     * DAFTAR IZIN (ADMIN)
     * GET /admin/izin
     */
    public function index()
    {
        // tampilkan semua izin beserta user-nya
        $izin = Izin::with('user')->latest()->get();
        return view('izin.index', compact('izin'));
    }

    /**
     * SETUJUI IZIN (ADMIN)
     * POST /admin/izin/{izin}/approve
     */
    public function approve(Izin $izin)
    {
        // ubah status izin
        $izin->update(['status' => 'approved']);

        // sinkron ke riwayat absensi: tandai hari tsb sebagai "Izin"
        // gunakan updateOrCreate agar tidak dobel
        Absensi::updateOrCreate(
            [
                'user_id' => $izin->user_id,
                'tanggal' => Carbon::parse($izin->tanggal_izin)->toDateString(),
            ],
            [
                'status'     => 'Izin',
                'shift'      => null,
                'jam_masuk'  => null,
            ]
        );

        return back()->with('ok', 'Izin disetujui & riwayat diperbarui.');
    }

    /**
     * TOLAK IZIN (ADMIN)
     * POST /admin/izin/{izin}/reject
     */
    public function reject(Izin $izin)
    {
        $izin->update(['status' => 'rejected']);

        // opsional: bersihkan entry absensi "Izin" tanpa jam_masuk jika sudah terlanjur dibuat
        $absen = Absensi::where('user_id', $izin->user_id)
            ->whereDate('tanggal', Carbon::parse($izin->tanggal_izin)->toDateString())
            ->where('status', 'Izin')
            ->whereNull('jam_masuk')
            ->first();

        if ($absen) {
            $absen->delete();
        }

        return back()->with('ok', 'Izin ditolak.');
    }
}
