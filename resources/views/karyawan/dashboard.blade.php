@extends('layouts.auth')
@section('title','Karyawan Dashboard')

@push('styles')
<style>
  :root{
    --bg:#deeae2; --panel:#e9f0ea; --header:#8fb3bb; --card:#f7f0ea; --ink:#2a4d52;
  }

  /* === FULL EDGE-TO-EDGE === */
  .k-wrap{min-height:100dvh;background:var(--panel);padding:0}                 /* ⬅️ no side padding */
  .k-shell{width:100vw;max-width:100vw;margin:0}                               /* ⬅️ span full viewport width */
  .k-header{background:var(--header);color:#0a2a30;border-radius:0;            /* ⬅️ no radius */
            padding:24px 28px;display:flex;gap:14px;align-items:center;width:100%}
  .k-avatar{width:56px;height:56px;border-radius:50%;background:#d7d7d7;flex:0 0 56px;
            box-shadow:inset 0 2px 6px rgba(0,0,0,.15)}
  .k-name{font-weight:700;font-size:20px;line-height:1}
  .k-role{font-size:12px;opacity:.8;margin-top:4px}

  .k-body{background:var(--bg);padding:28px;border-radius:0;                    /* ⬅️ no radius, full width */
          box-shadow:0 10px 20px rgba(0,0,0,.08) inset;width:100%}

  .k-actions{display:flex;gap:28px;justify-content:center;margin:18px 0 24px;flex-wrap:wrap}
  .k-action{flex:1;min-width:200px;max-width:260px;background:#fff;border-radius:14px;
            padding:16px;text-align:center;box-shadow:0 6px 14px rgba(0,0,0,.12);
            border:1px solid rgba(0,0,0,.08);transition:.15s ease}
  .k-action:hover{transform:translateY(-2px);box-shadow:0 10px 18px rgba(0,0,0,.15)}
  .k-action i{display:block;font-style:normal;font-size:34px;margin-bottom:6px}

  /* === Cards & Graph truly full width === */
  .k-card{background:var(--card);border-radius:0;padding:22px;margin:0 0 20px; /* ⬅️ radius 0 + full width */
          width:100%;box-shadow:0 8px 16px rgba(0,0,0,.08);border:1px solid rgba(0,0,0,.06)}
  .k-card h3{font-size:14px;color:var(--ink);margin-bottom:10px;letter-spacing:.2px}

  .k-graph{background:#e0ebe4;border:1px solid rgba(0,0,0,.08);padding:16px 16px 8px;
           border-radius:0;width:100%}                                         /* ⬅️ radius 0 + full width */
  .k-graph > .chart-box{height:360px}
  .k-graph canvas{width:100% !important;height:100% !important}

  .k-topbar{display:flex;justify-content:flex-end;gap:8px;margin-left:auto}
  .k-btn{background:#2a4d52;color:#fff;border:none;border-radius:10px;padding:8px 12px;
         font-size:12px;cursor:pointer}
  .k-btn.outline{background:transparent;color:#2a4d52;border:1px solid #2a4d52}

  /* optional: hindari scroll horizontal karena 100vw di OS tertentu */
  html,body{overflow-x:hidden}
</style>
@endpush

@section('content')
<div class="k-wrap">
  <div class="k-shell">
    {{-- Header --}}
    <div class="k-header">
      <div class="k-avatar" aria-hidden="true"></div>
      <div>
        <div class="k-name">{{ auth()->user()->name }}</div>
        <div class="k-role">Karyawan</div>
      </div>
      <div class="k-topbar">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="k-btn outline" type="submit">Logout</button>
        </form>
      </div>
    </div>

    {{-- Body --}}
    <div class="k-body">
      <div class="k-actions">
        <a class="k-action" href="{{ route('izin.create') }}">
          <i>📝</i>
          <div>Ajukan Izin</div>
        </a>
        <a class="k-action" href="{{ route('absensi.riwayat') }}">
          <i>📷</i>
          <div>Riwayat Absensi</div>
        </a>
      </div>

      <div class="k-card">
        <h3>Informasi</h3>
        <div>{!! $info ?? 'Informasi di sini' !!}</div>
      </div>

      <div class="k-graph">
        <h4 style="text-align:center;color:#2a4d52;margin:0 0 8px">Ranking Kehadiran Per Bulan</h4>
        <div class="chart-box">
          <canvas id="attendanceChart"></canvas>
        </div>
        <div id="legend" style="font-size:11px;margin:8px auto 0;color:#334;opacity:.9"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const labels   = @json(array_keys($attendance ?? []));
  const dataset1 = @json(array_values($attendance ?? []));

  const ctx = document.getElementById('attendanceChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Persentase Hadir (%)',
        data: dataset1,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false, // ikut tinggi .chart-box
      scales: { y: { beginAtZero: true, ticks: { callback: v => v + '%' } } },
      plugins: { legend: { display: false } }
    }
  });

  const legend = labels.map((l,i)=> `${i+1}. <b>${l}</b>: ${dataset1[i]}%`).join(' &nbsp; ');
  document.getElementById('legend').innerHTML = legend;
});
</script>
@endpush
