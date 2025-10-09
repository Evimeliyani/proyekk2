<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiApiController extends Controller
{
    public function store(Request $request)
    {
        $data = Absensi::create([
            'Id' => $request->user_id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => now()->toTimeString(),
            'status' => 'Hadir'
        ]);

        return response()->json([
            'message' => 'Absensi berhasil disimpan',
            'data' => $data
        ], 201);
    }
}
