<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Izin/Cuti (Layout Lebih Lebar)</title>
    <style>
        /* Variabel Warna Utama */
        :root {
            --primary-color: #6a9590; /* Warna Header Hijau */
            --secondary-color: #e8f0e3; /* Warna Background Body/Form */
            --card-bg: #fffbf7; /* Warna Latar Kartu/Form */
            --text-dark: #333;
            --text-light: #f4f4f4;
            --form-bg: #c0ccc3; /* Warna Latar Belakang Input */
            --button-color: #6a9590; 
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--secondary-color);
            margin: 0;
            padding: 40px 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            /* === MODIFIKASI UNTUK LEBIH LEBAR === */
            width: 90%; 
            max-width: 1200px; /* Diperlebar menjadi 1200px */
            box-shadow: var(--box-shadow);
            background-color: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            /* === AKHIR MODIFIKASI === */
        }

        /* 1. HEADER */
        .header-section {
            background-color: var(--primary-color);
            padding: 20px 40px; /* Padding horizontal diperbesar */
            color: var(--text-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .back-link {
            text-decoration: none;
            color: inherit;
        }

        .back-icon {
            font-size: 2em;
            cursor: pointer;
            margin-right: 15px;
            display: block;
            line-height: 1;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .profile-circle {
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            margin-left: 15px;
            flex-shrink: 0;
        }
        
        .user-details {
            font-size: 0.9em;
            margin-right: 10px;
            text-align: right;
        }
        
        .user-details strong {
            display: block;
            font-size: 1.1em;
            line-height: 1.2;
        }

        /* 2. FORM BODY */
        .form-section {
            padding: 40px 60px; /* Padding lebih besar untuk ruang yang nyaman */
            background-color: var(--secondary-color);
            min-height: 60vh; 
        }

        .form-card {
            background-color: var(--form-bg);
            padding: 40px; /* Padding lebih besar */
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 5px;
            font-size: 1.1em;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: var(--card-bg);
            color: var(--text-dark);
            font-size: 1em;
            margin-top: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        /* Gaya khusus untuk label (sesuai gambar) */
        .input-display {
            background-color: rgba(255, 255, 255, 0.5); 
            padding: 15px;
            border-radius: 8px;
            color: var(--text-dark);
            font-size: 1em;
            margin-top: 5px;
            font-weight: normal;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Kustomisasi agar mirip tampilan gambar */
        .field-box {
            background-color: var(--card-bg); 
            padding: 20px; /* Padding field box diperbesar */
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 1.1em;
            font-weight: 500;
        }
        
        .field-box label {
            font-weight: bold;
        }


        /* 3. TOMBOL KIRIM */
        .submit-container {
            text-align: right; 
            margin-top: 30px;
        }

        .submit-button {
            background-color: var(--button-color);
            color: white;
            padding: 12px 35px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1.1em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.1s;
        }

        .submit-button:hover {
            background-color: #58807b;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-left">
                <a href="{{ route('karyawan.dashboard') }}" class="back-link">
                    <span class="back-icon">&#x2190;</span> 
                </a>
            </div>
            <div class="user-info">
                <div class="user-details">
                    <strong>{{ Auth::user()->nama ?? 'Evi Meliyani' }}</strong>
                    <span>Karyawan</span>
                </div>
                <div class="profile-circle">
                    </div>
            </div>
        </div>

        <div class="form-section">
            <form action="#" method="POST" class="form-card">
                @csrf
                
                <div class="field-box">
                    <label>Nama</label>
                    <div class="input-display">{{ Auth::user()->nama ?? 'Evi Meliyani' }}</div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? '001' }}">
                </div>

                <div class="field-box">
                    <label for="tanggal_izin">Tanggal Izin</label>
                    <input type="date" id="tanggal_izin" name="tanggal_izin" class="form-input" required>
                </div>

                <div class="field-box">
                    <label for="jenis_izin">Jenis Izin</label>
                    <select id="jenis_izin" name="jenis_izin" class="form-select" required>
                        <option value="">Pilih Jenis Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Cuti">Cuti (Libur Tahunan)</option>
                        <option value="Izin Pribadi">Izin Pribadi (Keperluan Mendesak)</option>
                    </select>
                </div>

                <div class="field-box">
                    <label for="alasan">Alasan</label>
                    <textarea id="alasan" name="alasan" class="form-textarea" placeholder="Jelaskan alasan pengajuan izin/cuti Anda..." required></textarea>
                </div>

                <div class="submit-container">
                    <button type="submit" class="submit-button">Kirim</button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>