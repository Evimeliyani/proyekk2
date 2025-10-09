<?php

// App\Http\Controllers\QRCodeController.php
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Pastikan library ini sudah terinstal
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class QRCodeController extends Controller
{
    public function generate(Request $request)
    {
        $user = Auth::user();

        // 1. BUAT TOKEN DINAMIS (Contoh: UUID + User ID)
        // Ini yang akan di-scan. Token ini hanya valid sebentar.
        $token = Str::uuid() . '|' . $user->id; 

        // 2. SIMPAN TOKEN DI CACHE (Hanya berlaku selama 15 detik)
        // Di sisi scanner, server akan mengecek apakah token ini valid di Cache.
        Cache::put('qr_token:' . $token, $user->id, 15); 

        // 3. ENCODE TOKEN MENJADI GAMBAR QR
        $qrCodeImage = QrCode::size(250)
            ->margin(1)
            ->format('svg') // SVG lebih baik untuk web
            ->color(0, 0, 0)
            ->generate($token);

        // 4. KIRIM GAMBAR SEBAGAI RESPONS
        return response($qrCodeImage, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate'); // Penting agar tidak di-cache browser
    }
}
Dengan implementasi *backend* ini, QR Code akan benar-benar berubah setiap 10 detik, dan hanya *token* yang paling baru yang bisa digunakan untuk absensi.