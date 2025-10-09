<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <style>
        /* Gaya dasar */
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f0e3; /* Warna latar belakang umum (Hijau Muda Sangat Pucat) */
            margin: 0;
            padding: 20px 0; 
            display: flex;
            justify-content: center;
        }
        .container {
            width: 95%; /* Lebih lebar */
            max-width: 1200px; /* Batas lebar maksimum yang lebih besar untuk tampilan web */
            background-color: #e8f0e3; 
            margin: 0 auto;
        }

        /* --- Tampilan Header (Profil) --- */
        .header-area {
            background-color: #a3c4b7; /* Warna Hijau Mint/Sage Tua untuk latar belakang */
            border-top: 10px solid #759a8c; /* Garis Biru/Hijau Tua di atas */
            border-bottom: 5px solid #759a8c; /* Garis Biru/Hijau Tua di bawah */
            padding: 15px 30px; /* Padding di dalam header */
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between; /* Tambahan untuk memastikan jika ada elemen lain di header */
        }
        
        .profile-area {
            display: flex;
            align-items: center;
        }

        .profile-pic {
            width: 70px; /* Sedikit lebih besar */
            height: 70px;
            background-color: #d1d9d5; 
            border-radius: 50%;
            margin-right: 20px;
            /* Border luar putih untuk efek highlight, sesuai gambar */
            border: 4px solid #f4f4f4; 
            /* Tambahan: Untuk menampilkan inisial jika tidak ada gambar */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #759a8c;
        }
        .user-info h2 {
            margin: 0;
            color: #333;
            font-size: 1.3em;
            font-weight: bold;
        }
        .user-info p {
            margin: 2px 0 0;
            color: #555;
            font-size: 1em;
        }
        
        /* --- Tampilan Menu Grid (Izin, Riwayat) --- */
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .menu-grid {
            display: flex;
            justify-content: center; /* Pusatkan menu */
            gap: 30px; /* Jarak antar item menu */
            padding: 10px 0 30px 0; 
            width: 100%; /* Lebar penuh */
        }

        .menu-link {
            text-decoration: none; 
            color: #333; 
            width: 25%; 
            max-width: 200px;
            text-align: center;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        /* Gaya Kotak Ikon */
        .menu-icon-box {
            width: 100%;
            height: 100px; 
            background-color: #d1d9d5; 
            border-radius: 8px; 
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .menu-link:hover .menu-icon-box {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .menu-icon-box i {
            font-style: normal;
            font-size: 3em; 
            color: #555; 
        }
        
        .menu-item span {
            font-size: 1em;
            font-weight: bold;
            padding: 5px 0;
        }

        /* --- Kotak Informasi --- */
        .info-box {
            width: 85%; 
            background-color: #f7f3ed; 
            padding: 60px 40px; 
            margin: 10px 0 30px 0;
            text-align: center;
            border-radius: 8px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
            color: #666;
            font-size: 1.2em;
            height: 150px; 
        }

        /* --- Kotak Ranking --- */
        .ranking-box {
            background-color: #92b0a3; 
            padding: 20px 40px; 
            margin: 0; 
            border-radius: 8px;
            color: #333; 
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 85%; 
        }
        .ranking-box h3 {
            margin-top: 0;
            color: #1a1a1a;
            font-size: 1.2em;
            margin-bottom: 15px;
        }
        .ranking-content {
            display: flex;
            width: 100%;
            justify-content: space-between; 
            align-items: flex-end; 
            padding: 10px 0;
        }
        
        /* Area Grafik Bar */
        .bar-chart-area {
            width: 60%; 
            height: 120px; 
            display: flex;
            align-items: flex-end; 
            justify-content: space-around;
            gap: 10px;
        }
        .bar {
            width: 15px; 
            background-color: #5e7a68; 
            border-radius: 4px 4px 0 0;
        }

        /* Area Legenda Ranking */
        .ranking-legend {
            width: 35%;
            text-align: left;
            font-size: 0.9em; 
            color: #1a1a1a;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .legend-color {
            width: 10px;
            height: 10px;
            margin-right: 8px;
            border-radius: 2px;
        }
        .legend-item.evi .legend-color {
            background-color: #3f5a4a; 
        }
        .legend-item.evi {
            font-weight: bold;
        }

        /* Pengaturan tinggi bar */
        .bar-1 { height: 95%; } 
        .bar-2 { height: 85%; } 
        .bar-3 { height: 75%; } 
        .bar-4 { height: 60%; } 
        .bar-5 { height: 50%; } 
        .bar-6 { height: 40%; } 
        .bar-7 { height: 10%; background-color: #3f5a4a;} /* Bar Evi */
        
        .bar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            height: 100%; 
        }
        .bar-container span {
            font-size: 0.7em;
            color: #333;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header-area">
            <div class="profile-area">
                
                {{-- Logika untuk mengambil inisial --}}
                @php
                    $user = Auth::user();
                    // Coba ambil 'nama' atau 'name', default 'Guest'
                    $displayName = $user ? ($user->nama ?? $user->name ?? 'Guest') : 'Evi Meliyani';
                    // Ambil inisial (contoh: Evi Meliyani -> EM)
                    $initials = '';
                    if ($displayName !== 'Guest' && $displayName !== 'Evi Meliyani') {
                        $parts = explode(' ', $displayName);
                        $initials = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
                    } else {
                         // Fallback inisial statis jika belum login
                         $initials = 'EM';
                    }
                @endphp

                <div class="profile-pic">
                    {{ $initials }}
                </div>
                
                <div class="user-info">
                    <h2>{{ $displayName }}</h2>
                    <p>Karyawan</p>
                </div>
            </div>
            
            {{-- Tambahkan tombol logout di sini agar lengkap --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background: none; border: 1px solid #759a8c; color: #759a8c; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Logout
                </button>
            </form>
        </div>

        <div class="main-content">
            <div class="menu-grid">
                
                <a href="{{ url('/izin') }}" class="menu-link">
                    <div class="menu-item">
                        <div class="menu-icon-box">
                            <i style="font-style: normal;">📝</i> 
                        </div> 
                        <span>Ajukan Izin</span>
                    </div>
                </a>
                
                <a href="{{ url('/riwayat_absensi') }}" class="menu-link">
                    <div class="menu-item">
                        <div class="menu-icon-box">
                            <i style="font-style: normal;">⏰</i>
                        </div> 
                        <span>Riwayat Absensi</span>
                    </div>
                </a>
                
            </div>

            <div class="info-box">
                Informasi disini
            </div>

            <div class="ranking-box">
                <h3>Ranking Kehadiran Per Bulan</h3>
                <div class="ranking-content">
                    
                    <div class="bar-chart-area">
                        <div class="bar-container">
                            <div class="bar bar-1"></div><span>Pajak</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-2"></div><span>Cantika</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-3"></div><span>Hari</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-4"></div><span>Fazhan</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-5"></div><span>Siwi</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-6"></div><span>Devi</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-7"></div><span>Evi</span>
                        </div>
                    </div>
                    
                    <div class="ranking-legend">
                        <div class="legend-item"><span class="legend-color" style="background-color: #5e7a68;"></span>Pajak: 30 (19.4%)</div>
                        <div class="legend-item"><span class="legend-color" style="background-color: #5e7a68;"></span>Cantika: 28 (16.2%)</div>
                        <div class="legend-item"><span class="legend-color" style="background-color: #5e7a68;"></span>Hari: 27 (17.5%)</div>
                        <div class="legend-item"><span class="legend-color" style="background-color: #5e7a68;"></span>Fazhan: 24 (17.0%)</div>
                        <div class="legend-item"><span class="legend-color" style="background-color: #5e7a68;"></span>Siwi: 19 (12.4%)</div>
                        <div class="legend-item"><span class="legend-color" style="background-color: #5e7a68;"></span>Devi: 18 (11.8%)</div>
                        <div class="legend-item evi"><span class="legend-color" style="background-color: #3f5a4a;"></span>**Evi: 5 (2.2%)**</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>