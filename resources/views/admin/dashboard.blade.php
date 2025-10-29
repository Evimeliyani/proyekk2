@extends('layouts.auth')
@section('title','Admin Dashboard')

@push('styles')
<style>
  :root{
    --bg:#deeae2; --panel:#e9f0ea; --header:#8fb3bb; --ink:#2a4d52; --card:#ffffff;
  }
  body,html{background:var(--panel)}
  .layout{display:grid;grid-template-columns:240px 1fr;min-height:100dvh}

  /* sidebar */
  .side{background:#2b555b;color:#fff;padding:18px;display:flex;flex-direction:column;gap:12px}
  .avatar{width:90px;height:90px;border-radius:50%;background:#cfd8dc;margin:10px auto}
  .name{text-align:center;font-weight:700}
  .edit{font-size:12px;opacity:.85;text-align:center;margin-top:-6px}
  .menu a{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid rgba(255,255,255,.3);
          border-radius:10px;color:#e6f1f2;text-decoration:none}
  .menu a.active, .menu a:hover{background:#5e868d}

  /* main */
  .main{background:var(--bg)}
  .topbar{background:var(--header);padding:14px 20px;color:#0a2a30;font-weight:700;text-align:center}
  .content{padding:18px 22px}
  .card{background:var(--card);border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.08);
        padding:16px;border:1px solid rgba(0,0,0,.06)}
  .grid{display:grid;gap:16px}
  .grid-2{grid-template-columns:1fr 1fr}
  .grid-3{grid-template-columns:1fr}

  @media(min-width:980px){ .grid-3{grid-template-columns:1fr} }
  @media(min-width:1100px){ .grid-3{grid-template-columns:1fr} }
  .pill{background:#d8eadf;padding:10px;border-radius:12px;display:flex;align-items:center;gap:8px}
  .legend{font-size:12px;color:#233b3f}
  .legend li{list-style:none;margin:2px 0}
  canvas{width:100%!important;height:320px!important}
</style>
@endpush

@section('content')
<div class="layout">
  {{-- SIDEBAR --}}
  <aside class="side">
    <div class="avatar"></div>
    <div class="name">Admin</div>
    

    <nav class="menu" style="display:flex;flex-direction:column;gap:10px;margin-top:8px">
      <a class="active" href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
      <a href="{{ route('admin.karyawan.index') }}">👥 Data Karyawan</a>
      <a href="{{ route('admin.presensi.index') }}">🕒 Presensi</a>
      <a href="{{ route('admin.laporan.index') }}">📊 Laporan</a>
      <a href="{{ route('izin.index') }}">✅ Persetujuan Izin</a>
    </nav>
  </aside>

  {{-- MAIN --}}
  <main class="main">
    <div class="topbar">
  Selamat Datang, Admin - Dapur Ibu Soniya
  <form method="POST" action="{{ route('logout') }}" style="display:inline; float:right; margin-top:-4px">
    @csrf
    <button type="submit" style="padding:6px 12px;margin-left:12px;background:#2a4d52;
           color:#fff;border:none;border-radius:8px;cursor:pointer">
      Logout
    </button>
  </form>
</div>

    <div class="content">
      <h3 style="margin:6px 0 12px;color:#1f3c40">🛡️ Dashboard</h3>

      {{-- baris 1: info izin + info box + pie --}}
      <div class="grid grid-2" style="grid-template-columns:1.2fr 1fr">
        <div class="grid grid-3">
          <div class="card pill">📄 <b>{{ $izinPending }}</b> permohonan izin menunggu persetujuan</div>
          <div class="card" style="height:160px;display:flex;align-items:center;justify-content:center;background:#f8efe8">
            Tambahkan Informasi disini
          </div>
        </div>

        <div class="card">
          <div style="font-weight:600;margin-bottom:8px">Kehadiran hari ini</div>
          <canvas id="pieToday"></canvas>
          <ul class="legend" id="pieLegend" style="margin-top:6px"></ul>
        </div>
      </div>

      {{-- baris 2: bar chart --}}
      <div class="card" style="margin-top:16px">
        <div style="font-weight:600;margin-bottom:8px">Ranking Kehadiran Per Bulan ({{ $bulanJudul }})</div>
        <canvas id="barMonth"></canvas>
        <div id="barLegend" class="legend" style="margin-top:6px"></div>
      </div>
    </div>
  </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const pieLabels = @json($pieLabels);
const pieValues = @json($pieValues);
const totalHariIni = @json($totalHariIni);

const barLabels = @json($barLabels);
const barValues = @json($barValues);

document.addEventListener('DOMContentLoaded', () => {
  // PIE (kehadiran hari ini)
  const pctx = document.getElementById('pieToday').getContext('2d');
  new Chart(pctx, {
    type: 'pie',
    data: { labels: pieLabels, datasets: [{ data: pieValues }] },
    options: { responsive:true, plugins:{ legend:{ display:false } } }
  });
  // legenda pie
  const pct = totalHariIni ? pieValues.map(v => (v*100/totalHariIni).toFixed(1)) : pieValues.map(()=>0);
  document.getElementById('pieLegend').innerHTML = pieLabels.map((l,i)=> `<li>${l}: <b>${pieValues[i]}</b> (${pct[i]}%)</li>`).join('');

  // BAR (ranking bulan ini)
  const bctx = document.getElementById('barMonth').getContext('2d');
  new Chart(bctx, {
    type: 'bar',
    data: { labels: barLabels, datasets: [{ label:'Hadir', data: barValues, borderWidth:1 }] },
    options: { responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true } } }
  });
  document.getElementById('barLegend').innerHTML =
    barLabels.map((l,i)=> `${i+1}. <b>${l}</b>: ${barValues[i] ?? 0}`).join(' &nbsp; ');
});
</script>
@endpush
