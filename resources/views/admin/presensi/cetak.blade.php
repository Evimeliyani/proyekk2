<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Presensi - {{ $tanggal }}</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#222;margin:30px;}
    h2{text-align:center;margin-bottom:0;}
    h4{text-align:center;margin-top:4px;font-weight:normal}
    table{width:100%;border-collapse:collapse;margin-top:25px;}
    th,td{border:1px solid #555;padding:8px 10px;}
    th{background:#eee;}
    tr:nth-child(even){background:#f8f8f8;}
    .status{font-weight:bold;}
    .ok{color:#1a7a3c;}
    .alfa{color:#c33;}
    .izin{color:#1e5ea8;}
    .late{color:#a67800;}
    .footer{text-align:right;margin-top:40px;font-style:italic;}
    @media print{
      .noprint{display:none}
    }
  </style>
</head>
<body>
  <div class="noprint" style="text-align:right;margin-bottom:8px;">
    <button onclick="window.print()">🖨️ Cetak</button>
  </div>

  <h2>Rekap Presensi Harian</h2>
  <h4>Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h4>

  <table>
    <thead>
      <tr>
        <th style="width:90px">UID</th>
        <th>Nama</th>
        <th style="width:130px">Jam Masuk</th>
        <th style="width:120px">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        @php
          $cls = match(strtolower($r['status'])){
            'hadir' => 'ok',
            'terlambat' => 'late',
            'izin' => 'izin',
            default => 'alfa'
          };
        @endphp
        <tr>
          <td>{{ $r['uid'] }}</td>
          <td>{{ $r['nama'] }}</td>
          <td>{{ $r['jam'] }}</td>
          <td class="status {{ $cls }}">{{ ucfirst($r['status']) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }}
  </div>
</body>
</html>
