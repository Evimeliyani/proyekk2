<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $ranking = Absensi::selectRaw('Id, count(*) as total')
            ->groupBy('Id')
            ->orderByDesc('total')
            ->take(5)
            ->with('user')
            ->get();

        return view('dashboard', compact('ranking'));
    }
}

