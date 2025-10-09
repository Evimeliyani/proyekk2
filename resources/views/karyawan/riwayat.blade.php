<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi - Tampilan Full Width</title>
    <style>
        /* Variabel Warna Utama */
        :root {
            --primary-color: #6a9590; 
            --secondary-color: #e8f0e3; 
            --card-bg: #fffbf7; /* Warna Latar Konten Utama */
            --text-dark: #333;
            --text-light: #f4f4f4;
            --table-header: #3e706c; 
            --border-color: #c0ccc3;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --hadir: #4CAF50; 
            --alfa: #F44336; 
            --terlambat: #FFC107; 
            --izin: #64B5F6; 
            --hover-color: #5a837e; 
            --content-padding: 40px; /* Padding konten utama untuk desktop */
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--secondary-color);
            margin: 0;
            padding: 0; /* Menghapus padding body agar container bisa full width */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            /* PERUBAHAN UTAMA: Menghilangkan max-width untuk full width */
            width: 100%;
            /* background-color dihilangkan karena konten akan menggunakan card-bg */
            padding-bottom: 20px;
            /* box-shadow dan border-radius dihapus karena tidak lagi berfungsi sebagai "kartu" */
            overflow: hidden;
            background-color: var(--card-bg); /* Konten utama tetap berwarna putih/card-bg */
        }

        /* 1. HEADER (Full Width) */
        .header-section {
            background-color: var(--primary-color);
            padding: 20px var(--content-padding); /* Menggunakan variabel padding */
            color: var(--text-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .back-link { text-decoration: none; color: inherit; }
        .back-icon { font-size: 2em; cursor: pointer; margin-right: 15px; display: block; line-height: 1; }
        .user-info { display: flex; align-items: center; text-align: right; }
        .profile-circle { 
            width: 50px; height: 50px; 
            background-color: rgba(255, 255, 255, 0.7); border-radius: 50%; 
            margin-left: 15px; flex-shrink: 0; 
            display: flex; justify-content: center; align-items: center; 
            font-size: 1.5em; color: var(--primary-color); font-weight: bold;
        }
        .user-details { font-size: 0.9em; }
        .user-details strong { display: block; font-size: 1.1em; line-height: 1.2; }

        /* 2. KONTROL FILTER & JUDUL (Full Width) */
        .controls-section {
            padding: 15px var(--content-padding); /* Menggunakan variabel padding */
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            position: relative; 
        }

        .title {
            display: flex;
            align-items: center;
            font-size: 1.2em; 
            font-weight: bold;
            color: var(--text-dark);
        }

        .title span { margin-right: 8px; font-size: 1.3em; }

        /* Style untuk tombol filter */
        .month-filter {
            padding: 8px 15px;
            background-color: var(--primary-color);
            color: var(--text-light);
            border: none;
            border-radius: 20px;
            font-size: 1em; 
            cursor: pointer;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }
        .month-filter:hover { background-color: var(--hover-color); }

        /* ----- DROPDOWN BULAN BARU ----- */
        .month-dropdown {
            position: absolute;
            top: 100%; 
            right: var(--content-padding); /* Menyelaraskan dengan padding konten */
            z-index: 20;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            width: 180px;
            max-height: 300px;
            overflow-y: auto;
            display: none; 
        }

        .month-dropdown.show { display: block; }
        .month-dropdown a {
            display: block; padding: 10px 15px; text-decoration: none; 
            color: var(--text-dark); font-size: 0.95em; transition: background-color 0.2s;
        }
        .month-dropdown a:hover { background-color: var(--secondary-color); }
        .month-dropdown a.active { background-color: var(--primary-color); color: var(--text-light); font-weight: bold; }
        /* ------------------------------- */

        /* 3. TABEL RIWAYAT (Full Width) */
        .table-section {
            /* Menghilangkan padding kiri/kanan, tapi konten dalamnya akan punya padding */
            padding: 0 0 10px 0; 
            overflow-x: auto;
        }
        
        .table-content-wrapper {
            /* Kontainer ini memberikan padding yang konsisten untuk konten tabel */
            padding: 0 var(--content-padding);
        }

        .absensi-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em; 
            /* min-width dipertahankan untuk memastikan kolom tidak terlalu sempit */
            min-width: 900px; 
        }

        .absensi-table th {
            background-color: var(--table-header);
            color: var(--text-light);
            padding: 12px 10px; 
            text-align: center;
            font-weight: bold;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .absensi-table th:last-child { border-right: none; }
        .absensi-table td { padding: 10px; text-align: center; border-bottom: 1px solid var(--border-color); color: var(--text-dark); vertical-align: middle; }
        .absensi-table tr:nth-child(even) { background-color: rgba(232, 240, 227, 0.5); }
        .absensi-table tr:hover { background-color: rgba(192, 204, 195, 0.4); }
        .status-icon { font-size: 1.2em; line-height: 1; margin-left: 5px; }
        .absensi-table td:nth-child(5) { display: flex; justify-content: center; align-items: center; }
        .status-hadir { color: var(--hadir); }
        .status-alfa { color: var(--alfa); }
        .status-terlambat { color: var(--terlambat); }
        .status-izin { color: var(--izin); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <a href="{{ route('karyawan.dashboard') }}" class="back-link">
                <span class="back-icon">&#x2190;</span> 
            </a>
            <div class="user-info">
                <div class="user-details">
                    <strong>{{ Auth::user()->nama ?? 'Evi Meliyani' }}</strong>
                    <span>Karyawan</span>
                </div>
                <div class="profile-circle">
                    K1
                </div>
            </div>
        </div>

        <div class="controls-section">
            <div class="title">
                <span>&#x1F4C6;</span> 
                Riwayat Absensi
            </div>
            
            <button id="monthFilterButton" class="month-filter" onclick="toggleDropdown()">
                <span id="selectedMonth">&#x25BC; Desember</span> 
            </button>

            <div id="monthDropdown" class="month-dropdown">
                <a href="#" data-month="Januari" onclick="selectMonth(this, 'Januari 2025')">Januari</a>
                <a href="#" data-month="Februari" class="active" onclick="selectMonth(this, 'Februari 2025')">Februari</a>
                <a href="#" data-month="Maret" onclick="selectMonth(this, 'Maret 2025')">Maret</a>
                <a href="#" data-month="April" onclick="selectMonth(this, 'April 2025')">April</a>
                <a href="#" data-month="Mei" onclick="selectMonth(this, 'Mei 2025')">Mei</a>
                <a href="#" data-month="Juni" onclick="selectMonth(this, 'Juni 2025')">Juni</a>
                <a href="#" data-month="Juli" onclick="selectMonth(this, 'Juli 2025')">Juli</a>
                <a href="#" data-month="Agustus" onclick="selectMonth(this, 'Agustus 2025')">Agustus</a>
                <a href="#" data-month="September" onclick="selectMonth(this, 'September 2025')">September</a>
                <a href="#" data-month="Oktober" onclick="selectMonth(this, 'Oktober 2025')">Oktober</a>
                <a href="#" data-month="November" onclick="selectMonth(this, 'November 2025')">November</a>
                <a href="#" data-month="Desember" onclick="selectMonth(this, 'Desember 2025')">Desember</a>
            </div>
        </div>

        <div class="table-section">
            <div class="table-content-wrapper">
                <table class="absensi-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>01/02/2025</td><td>001</td><td>Evi Meliyani</td><td>08:00</td><td><span title="Hadir">Hadir</span> <span class="status-icon status-hadir">&#x2714;</span></td></tr>
                        <tr><td>02/02/2025</td><td>001</td><td>Evi Meliyani</td><td>-</td><td><span title="Alfa">Alfa</span> <span class="status-icon status-alfa">&#x2718;</span></td></tr>
                        <tr><td>03/02/2025</td><td>001</td><td>Evi Meliyani</td><td>08:15</td><td><span title="Terlambat">Terlambat</span> <span class="status-icon status-terlambat">&#x26A0;</span></td></tr>
                        <tr><td>04/02/2025</td><td>001</td><td>Evi Meliyani</td><td>-</td><td><span title="Izin">Izin</span> <span class="status-icon status-izin">&#x1F4DD;</span></td></tr>
                        <tr><td>05/02/2025</td><td>001</td><td>Evi Meliyani</td><td>07:55</td><td><span title="Hadir">Hadir</span> <span class="status-icon status-hadir">&#x2714;</span></td></tr>
                        <tr><td>06/02/2025</td><td>001</td><td>Evi Meliyani</td><td>-</td><td><span title="Alfa">Alfa</span> <span class="status-icon status-alfa">&#x2718;</span></td></tr>
                        <tr><td>07/02/2025</td><td>001</td><td>Evi Meliyani</td><td>08:00</td><td><span title="Hadir">Hadir</span> <span class="status-icon status-hadir">&#x2714;</span></td></tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('monthDropdown');
            dropdown.classList.toggle('show');
        }

        function selectMonth(element, newText) {
            // 1. Update teks tombol filter
            document.getElementById('selectedMonth').textContent = '▼ ' + newText;
            
            // 2. Tandai link yang aktif
            const links = document.querySelectorAll('.month-dropdown a');
            links.forEach(link => link.classList.remove('active'));
            element.classList.add('active');

            // 3. Sembunyikan dropdown setelah memilih
            document.getElementById('monthDropdown').classList.remove('show');

            // 4. LOGIKA PENGAMBILAN DATA (Gunakan AJAX di sini untuk ambil data dari server)
            console.log("Memuat data absensi baru untuk: " + newText);
        }

        // Menutup dropdown jika klik di luar tombol filter
        window.onclick = function(event) {
            if (!event.target.matches('#monthFilterButton') && !event.target.closest('#monthFilterButton')) {
                const dropdown = document.getElementById('monthDropdown');
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>