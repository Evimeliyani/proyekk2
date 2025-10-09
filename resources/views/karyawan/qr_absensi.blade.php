<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Absensi</title>
    <style>
        /* Warna utama: Hijau keabu-abuan (seperti di gambar) */
        :root {
            --bg-color: #e8f0e3; /* Latar belakang body/umum */
            --header-color: #6a9590; /* Warna bagian atas QR */
            --text-dark: #333;
            --text-light: #f4f4f4;
            --card-bg: #fffbf7; /* Latar belakang kartu ID */
            --card-text-light: #c0ccc3;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 450px; 
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Bagian Atas: QR Code dan Header */
        .qr-section {
            background-color: var(--header-color);
            padding: 20px;
            color: var(--text-light);
            text-align: center;
            padding-bottom: 40px; 
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .back-icon {
            font-size: 1.5em;
            cursor: pointer;
            margin-right: 15px;
        }
        
        .back-link {
            text-decoration: none;
            color: inherit;
        }

        .instruction {
            font-size: 1em;
            margin-bottom: 30px;
        }

        .qr-box {
            background-color: white;
            padding: 15px;
            display: inline-block;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Styling untuk gambar QR Code */
        .qr-code img {
            width: 200px; /* Ukuran sesuai lebar box */
            height: 200px;
            display: block;
        }

        .timer-info {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
            color: var(--text-light);
        }
        
        /* Bagian Bawah: Kartu ID Karyawan */
        .id-card-section {
            background-color: var(--bg-color);
            padding: 0 20px 20px 20px;
            position: relative;
            z-index: 1; 
            padding-top: 0;
        }

        .id-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: var(--text-dark);
            transform: translateY(-20px); 
            position: relative;
        }
        
        .id-card::before, .id-card::after {
            content: '';
            position: absolute;
            background-color: var(--card-text-light);
            opacity: 0.3;
            border-radius: 50%;
        }

        .id-card::before {
            width: 120px;
            height: 120px;
            top: -40px;
            left: -30px;
            transform: rotate(15deg);
            clip-path: polygon(0 0, 100% 0, 0 100%); 
            border-radius: 0;
        }
        
        .id-card::after {
            width: 100px;
            height: 100px;
            bottom: -30px;
            left: 20px;
            border-radius: 50%;
            clip-path: circle(50% at 50% 50%);
        }

        .card-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative; 
            z-index: 2;
        }
        
        .user-details {
            text-align: left;
            padding-right: 15px;
        }
        
        .user-details p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        .user-details strong {
            font-size: 1.2em;
            color: var(--text-dark);
            display: block;
            margin-bottom: 3px;
        }

        .photo-box {
            width: 80px;
            height: 100px;
            background-color: black;
            border-radius: 8px;
            flex-shrink: 0; 
        }
        
        .additional-info {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.85em;
        }
        
    </style>
</head>
<body>
    <div class="container">
        
        <div class="qr-section">
            <div class="header">
                <!-- LINK KEMBALI KE DASHBOARD KARYAWAN -->
                <a href="{{ url('/karyawan/dashboard') }}" class="back-link">
                     <span class="back-icon">&#x2190;</span> 
                </a>
               
            </div>
            
            <p class="instruction">Tunjukkan QR Code ini ke alat scanner untuk melakukan absensi</p>
            
            <div class="qr-box">
                <!-- ELEMEN UNTUK MEMUAT GAMBAR QR CODE -->
                <div class="qr-code">
                    <img id="qrImage" src="" alt="Kode QR Absensi" />
                </div> 
            </div>
            
            <div class="timer-info">
                <span style="margin-right: 5px;">&#x26bf;</span> 
                Kode akan berganti dalam <span id="countdown">10</span> detik
            </div>
        </div>

        <div class="id-card-section">
            <div class="id-card">
                <div class="card-content">
                    <div class="user-details">
                        <p style="color: #666; margin-bottom: 0;">ID</p>
                        <strong>{{ Auth::user()->id ?? '001' }}</strong>
                        <p style="color: #666; margin-bottom: 0;">Nama</p>
                        <strong>{{ Auth::user()->nama ?? 'Evi Meliyani' }}</strong>
                        <p style="color: #666; margin-bottom: 0;">Email</p>
                        <strong>{{ Auth::user()->email ?? 'Evi@gmail.com' }}</strong>
                    </div>
                    <div class="photo-box">
                        <!-- Placeholder Foto -->
                    </div>
                </div>
                <div class="additional-info">
                    Toko Serba Rp 35.000
                </div>
            </div>
        </div>
        
    </div>

    <script>
        const countdownElement = document.getElementById('countdown');
        // Mendapatkan elemen <img> tempat QR Code akan dimuat
        const qrImageElement = document.getElementById('qrImage'); 
        let countdownValue = 10;
        const interval = 1000; // 1 detik
        
        // --- ROUTE API BARU (Mengambil URL dari Route Laravel) ---
        const qrApiUrl = "{{ route('api.qr.generate') }}"; 
        
        /**
         * Fungsi untuk memuat ulang gambar QR Code dari server
         * dengan menambahkan timestamp agar tidak menggunakan cache browser.
         */
        function changeQRCode() {
            // Tambahkan parameter waktu (t) yang unik agar browser tidak menggunakan cache
            const timestamp = Date.now();
            qrImageElement.src = qrApiUrl + '?t=' + timestamp;
            
            console.log('QR Code baru dimuat dari server pada ' + new Date().toLocaleTimeString());
        }
        
        function updateCountdown() {
            countdownValue--;
            countdownElement.textContent = countdownValue;

            if (countdownValue <= 0) {
                // Panggil fungsi untuk memuat ulang QR Code
                changeQRCode();
                
                // Reset timer
                countdownValue = 10;
                countdownElement.textContent = countdownValue;
            }
        }
        
        // Jalankan timer setiap 1 detik
        setInterval(updateCountdown, interval);
        
        // Muat QR Code pertama kali saat halaman dimuat
        changeQRCode(); 
    </script>
</body>
</html>
