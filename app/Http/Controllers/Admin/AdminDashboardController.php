<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $izinPending = Izin::where('status','pending')->count();

        $todayAgg = Absensi::select('status', DB::raw('count(*) as jml'))
            ->whereDate('tanggal', $today)
            ->groupBy('status')->pluck('jml','status');

        $pieLabels = ['Hadir','Izin','Terlambat','Alfa'];
        $pieValues = [
            (int)($todayAgg['Hadir'] ?? 0),
            (int)($todayAgg['Izin'] ?? 0),
            (int)($todayAgg['Terlambat'] ?? 0),
            (int)($todayAgg['Alfa'] ?? 0),
        ];
        $totalHariIni = array_sum($pieValues);

        $monthStart = $today->copy()->startOfMonth();
        $monthEnd   = $today->copy()->endOfMonth();

        $ranking = Absensi::select('user_id', DB::raw("SUM(status='Hadir') as hadir"))
            ->whereBetween('tanggal', [$monthStart, $monthEnd])
            ->groupBy('user_id')->orderByDesc('hadir')->take(8)->get();

        $barLabels = [];
        $barValues = [];
        foreach ($ranking as $r) {
            $u = User::find($r->user_id);
            $barLabels[] = $u?->name ?? ('User#'.$r->user_id);
            $barValues[] = (int)$r->hadir;
        }

        return view('admin.dashboard', [
            'izinPending'  => $izinPending,
            'pieLabels'    => $pieLabels,
            'pieValues'    => $pieValues,
            'totalHariIni' => $totalHariIni,
            'barLabels'    => $barLabels,
            'barValues'    => $barValues,
            'bulanJudul'   => $monthStart->translatedFormat('F Y'),
        ]);
    }
}
