{{-- resources/views/admin/presensi/index.blade.php --}}
@extends('layouts.auth')
@section('title', 'Presensi Harian')

@section('content')
<style>
  :root{
    --teal:#5b8784; --teal-dark:#3f6865; --cream:#efe3d5;
    --ink:#2c2c2c; --muted:#8b8b8b; --surface:#ffffff;
    --bord:#e7e2db; --bord2:#eadfd0; --thead:#4b7c78;
  }

  /* ====== RESET RINGAN ====== */
  body{background:#f6f5f2;}

  /* ====== FULL-BLEED WRAPPER (MELEBARKAN KONTEN) ====== */
  .full-bleed {
    /* trik agar keluar dari batas container parent dan jadi selebar viewport */
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    padding-left: 40px;
    padding-right: 40px;
  }

  /* ====== HEADER (lebar penuh juga) ====== */
  .topbar{
    background:var(--cream);
    border-bottom:1px solid #d7cab9;
    padding:1.1rem 2rem;
    font-weight:600;
    text-align:center;
    font-size:1.1rem;
    box-shadow:0 1px 4px rgba(0,0,0,0.08);
  }

  /* ====== CARD & ISI ====== */
  .card{
    background:var(--surface);
    border:1px solid var(--bord);
    border-radius:16px;
    padding:1.4rem 1.6rem;
    box-shadow:0 2px 6px rgba(0,0,0,0.06);
    width:100%;        /* penting: penuhi lebar wrapper */
    max-width: 1600px; /* biar tetap elegan di layar super lebar */
    margin: 24px auto; /* tengah-kan di dalam full-bleed */
  }

  .card-head{
    display:flex;align-items:center;justify-content:space-between;
    gap:1rem;flex-wrap:wrap;margin-bottom:1.1rem
  }
  .title{display:flex;align-items:center;gap:.6rem;font-weight:700;font-size:1.25rem;color:var(--ink)}
  .filters{display:flex;align-items:center;gap:.6rem;flex-wrap:wrap}

  .pill{
    background:var(--teal);color:#fff;border:none;border-radius:10px;
    padding:.65rem .95rem;display:inline-flex;align-items:center;gap:.5rem;
    cursor:pointer;font-weight:600
  }
  .btn{
    background:#2c2c2c;color:#fff;border:none;border-radius:10px;
    padding:.65rem 1rem;display:inline-flex;align-items:center;gap:.5rem;
    cursor:pointer;text-decoration:none;font-weight:600
  }
  .date-input{border:1px solid #d7cab9;border-radius:10px;padding:.55rem .7rem;background:#fff}

  /* ====== TABEL MELEBAR ====== */
  .table-wrap{border:1px solid var(--bord2);border-radius:12px;overflow:hidden;width:100%}
  table{width:100%;border-collapse:collapse;border-spacing:0}
  thead th{
    background:var(--teal);color:#fff;padding:1rem;font-weight:700;text-align:left;font-size:1rem
  }
  thead th+th{border-left:1px solid var(--thead)}
  tbody td{padding:1rem;border-top:1px solid #efe6da;font-size:.95rem;color:var(--ink)}
  tbody tr:nth-child(even){background:#fbf8f3}

  /* Badge status */
  .badge{display:inline-flex;align-items:center;gap:.4rem;font-weight:700;border-radius:20px;padding:.4rem .8rem;font-size:.9rem}
  .ok{background:#e7f6ee;color:#197a3c}
  .alfa{background:#fde9e9;color:#b23434}
  .late{background:#fff5df;color:#8a5a00}
  .izin{background:#ecf5ff;color:#205d9e}
  .icon{width:16px;height:16px;display:inline-block}
  .icon svg{width:16px;height:16px;display:block}

  @media (max-width: 768px){
    .full-bleed{padding-left:16px;padding-right:16px}
    .title{font-size:1.1rem}
    thead th, tbody td{padding:.8rem}
  }
</style>


{{-- KONTEN full width --}}
<div class="full-bleed">
  <div class="card">
    <div class="card-head">
      <div class="title">🗂️ <span>Presensi Harian</span></div>
      <div class="filters">
        <form method="GET" action="{{ route('admin.presensi.index') }}">
          <label class="pill" style="gap:.6rem; background:var(--teal-dark)">
            <span>▼</span>
            <input class="date-input" type="date" name="tanggal" value="{{ $tanggal ?? now()->toDateString() }}">
          </label>
          <button type="submit" class="pill">Terapkan</button>
        </form>
        <a class="btn"
           href="{{ route('admin.presensi.cetak', ['tanggal' => $tanggal ?? now()->toDateString()]) }}"
           target="_blank" rel="noopener">🖨️ Cetak</a>
      </div>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:150px">UID</th>
            <th>Nama</th>
            <th style="width:200px">Jam Masuk</th>
            <th style="width:180px">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($rows as $r)
            @php
              $statusLower = strtolower($r['status'] ?? '');
              $cls = match($statusLower){
                'hadir' => 'ok',
                'terlambat' => 'late',
                'izin' => 'izin',
                default => 'alfa'
              };
              $label = ucfirst($statusLower ?: '-');
            @endphp
            <tr>
              <td>{{ $r['uid'] ?? '-' }}</td>
              <td>{{ $r['nama'] ?? '-' }}</td>
              <td>{{ $r['jam'] ?? '-' }}</td>
              <td>
                <span class="badge {{ $cls }}">
                  @if($cls==='ok')
                    <span class="icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>
                    </span>
                  @elseif($cls==='alfa')
                    <span class="icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 5.71 12 12.01 5.7 5.71 4.29 7.12l6.3 6.29-6.3 6.29 1.41 1.41 6.3-6.29 6.3 6.29 1.41-1.41-6.3-6.29 6.3-6.29z"/></svg>
                    </span>
                  @elseif($cls==='late')
                    <span class="icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    </span>
                  @elseif($cls==='izin')
                    <span class="icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 2H8c-1.1 0-2 .9-2 2v14l6-3 6 3V4c0-1.1-.9-2-2-2z"/></svg>
                    </span>
                  @endif
                  {{ $label }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" style="text-align:center;color:var(--muted);padding:1rem">
                Belum ada data untuk tanggal ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
