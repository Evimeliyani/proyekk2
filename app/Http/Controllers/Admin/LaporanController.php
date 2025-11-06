<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        /**
         * ==========================
         * Ambil & Normalisasi Bulan
         * ==========================
         * Prioritas:
         *   1) ?year=YYYY & ?m=MM
         *   2) ?month=YYYY-MM
         *   3) default: bulan sekarang
         */
        $year = (int) $request->query('year', 0);
        $mon  = (int) $request->query('m', 0);

        if ($year > 0 && $mon >= 1 && $mon <= 12) {
            $monthStr = sprintf('%04d-%02d', $year, $mon);
        } else {
            $raw = trim((string) $request->input('month', now()->format('Y-m')));
            try {
                $tmp = Carbon::createFromFormat('Y-m', $raw);
            } catch (\Exception $e) {
                $tmp = now();
            }
            $monthStr = $tmp->format('Y-m');
        }

        // Buat objek Carbon berdasar monthStr yang sudah dipastikan valid
        $base  = Carbon::createFromFormat('Y-m', $monthStr);
        $start = $base->copy()->startOfMonth()->toDateString();
        $end   = $base->copy()->endOfMonth()->toDateString();

        // Jika bulan yang dipilih adalah bulan berjalan, totalHari = sampai hari ini
        $totalHari = $base->isSameMonth(now()) ? now()->day : $base->daysInMonth;

        /**
         * ==========================
         * Ambil daftar karyawan saja
         * ==========================
         * Jika kolommu berbeda (mis. is_admin = 0), ganti where('role','karyawan') sesuai skema DB kamu.
         */
        $users = User::where('role', 'karyawan')
            ->select('id', 'name')
            ->orderBy('id')
            ->get();

        /**
         * ==========================
         * Hitung HADIR (distinct tanggal)
         * ==========================
         * Status yang dihitung: 'hadir' dan 'terlambat' (case-insensitive, trim spasi).
         */
        $hadirMap = Absensi::select('user_id', DB::raw('COUNT(DISTINCT tanggal) as hadir_cnt'))
            ->whereBetween('tanggal', [$start, $end])
            ->where(function ($q) {
                $q->whereRaw("LOWER(TRIM(status)) = 'hadir'")
                  ->orWhereRaw("LOWER(TRIM(status)) = 'terlambat'");
            })
            ->groupBy('user_id')
            ->pluck('hadir_cnt', 'user_id');

        /**
         * ==========================
         * Hitung IZIN approved (distinct tanggal_izin)
         * ==========================
         * Hanya status 'approved' yang dihitung. 'panding/pending' diabaikan.
         */
        $izinMap = Izin::select('user_id', DB::raw('COUNT(DISTINCT tanggal_izin) as izin_cnt'))
            ->whereBetween('tanggal_izin', [$start, $end])
            ->whereRaw("LOWER(TRIM(status)) = 'approved'")
            ->groupBy('user_id')
            ->pluck('izin_cnt', 'user_id');

        /**
         * ==========================
         * Susun baris laporan
         * ==========================
         */
        $rows = $users->map(function ($u) use ($hadirMap, $izinMap, $totalHari) {
            $hadir = (int) ($hadirMap[$u->id] ?? 0);
            $izin  = (int) ($izinMap[$u->id] ?? 0);
            $alfa  = max($totalHari - $hadir - $izin, 0);

            return (object) [
                'uid'        => str_pad($u->id, 3, '0', STR_PAD_LEFT),
                'nama'       => $u->name,
                'hadir'      => $hadir,
                'izin'       => $izin,
                'alfa'       => $alfa,
                'totalKerja' => $totalHari,
            ];
        });

        // Kirim ke view
        return view('admin.laporan.index', [
            'rows'      => $rows,
            'monthStr'  => $monthStr,
            'totalHari' => $totalHari,
        ]);
    }
}
