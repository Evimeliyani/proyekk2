<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;

class IzinController extends Controller
{
    // GET /izin/ajukan
    public function create()
    {
        return view('izin.create'); // resources/views/izin/create.blade.php
    }

    // POST /izin/ajukan
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_izin' => 'required|date',
            'jenis_izin'   => 'required|string|max:100',
            'alasan'       => 'required|string|max:255',
        ]);

        $izin = Izin::create([
            'user_id'      => auth()->id(),
            'tanggal_izin' => $request->tanggal_izin,
            'jenis_izin'   => $request->jenis_izin,
            'alasan'       => $request->alasan,
            'status'       => 'pending',
        ]);

        // pilih salah satu:
        // return view('izin.sukses', compact('izin'));             // render langsung
        return redirect()->route('izin.sukses', $izin->id);         // atau redirect ke route sukses
    }

    // GET /izin/sukses/{izin}  (pakai kalau pilih redirect di atas)
    public function success(Izin $izin)
    {
        abort_if($izin->user_id !== auth()->id(), 403);
        return view('izin.sukses', compact('izin'));
    }
}
