public function store(Request $request)
{
    $request->validate([
        'uid' => 'required'
    ]);

    // cari UID pada tabel karyawans
    $karyawan = Karyawans::where('uid', $request->uid)->first();

    if (!$karyawan) {
        return response()->json(['status' => 'error', 'message' => 'UID tidak ditemukan'], 404);
    }

    $user_id = $karyawan->user_id;
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    // Cek apakah sudah presensi hari ini
    $cek = Absensis::where('user_id', $user_id)
                    ->where('tanggal', $tanggal)
                    ->first();

    if ($cek) {
        return response()->json(['status' => 'info', 'message' => 'Sudah presensi hari ini']);
    }

    Absensis::create([
        'user_id' => $user_id,
        'tanggal' => $tanggal,
        'status' => 'Hadir',
        'jam_masuk' => $jam
    ]);

    return response()->json(['status' => 'success', 'message' => 'Presensi tersimpan']);
}
