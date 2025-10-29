@extends('layouts.auth')
@section('title','Riwayat Absensi')

@push('styles')
<style>
  :root{
    --bg:#deeae2; --panel:#e9f0ea; --header:#8fb3bb; --ink:#2a4d52;
    --hadir:#25c23a; --alfa:#ff3b30; --izin:#f6e05e; --terlambat:#f59e0b;
  }
  /* Shell */
  .r-wrap{min-height:100dvh;background:var(--panel);padding:0}
  .r-shell{width:100%;max-width:100%}

  /* Header bar */
  .r-header{background:var(--header);color:#0a2a30;padding:14px 16px;display:flex;align-items:center;gap:10px}
  .r-back{background:#2a4d52;color:#fff;padding:6px 10px;border-radius:8px;text-decoration:none}
  .r-avatar{width:40px;height:40px;border-radius:50%;background:#d7d7d7}
  .r-info .name{font-weight:700;line-height:1}
  .r-info .role{font-size:12px;opacity:.85}
  .r-period{margin-left:auto;font-weight:600}

  /* Body */
  .r-body{background:var(--bg);padding:16px}
  .filters{display:flex;gap:6px;margin:10px 0}
  .sel{border:1px solid #c9d2cc;border-radius:8px;padding:6px 8px;background:#fff}
  .btn{background:#2a4d52;color:#fff;border:none;border-radius:8px;padding:6px 10px;cursor:pointer}

  /* Table */
  table.absensi{width:100%;border-collapse:collapse;background:#fff; box-shadow:0 6px 14px rgba(0,0,0,.08)}
  table.absensi th, table.absensi td{padding:10px 12px;border:1px solid #e6e6e6;font-size:13px;text-align:center}
  table.absensi th{background:#f5f5f5;color:#2f3d40;font-weight:600}

  /* Status dots */
  .dot{display:inline-block;width:12px;height:12px;border-radius:50%;vertical-align:middle}
  .hadir{background:var(--hadir)} .alfa{background:var(--alfa)}
  .izin{background:var(--izin)} .terlambat{background:var(--terlambat)}
  .legend{display:flex;gap:14px;align-items:center;flex-wrap:wrap;margin:8px 0 12px;font-size:12px;color:#213b40}
  .legend span{display:flex;align-items:center;gap:6px}
</style>
@endpush

@section('content')
<div class="r-wrap">
  <div class="r-shell">

    {{-- HEADER --}}
    <div class="r-header">
      <a class="r-back" href="{{ route('karyawan.dashboard') }}">←</a>
      <div class="r-avatar" aria-hidden="true"></div>
      <div class="r-info">
        <div class="name">{{ auth()->user()->name }}</div>
        <div class="role">Karyawan</div>
      </div>
      <div class="r-period">{{ $labelBulan }}</div>
    </div>

    {{-- BODY --}}
    <div class="r-body">

      {{-- Legend status (warna) --}}
      <div class="legend">
        <span><i class="dot hadir"></i> Hadir</span>
        <span><i class="dot terlambat"></i> Terlambat</span>
        <span><i class="dot izin"></i> Izin</span>
        <span><i class="dot alfa"></i> Alfa</span>
      </div>

      {{-- Filter bulan & tahun --}}
      <form method="get" class="filters">
        @php
          $months=[1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
          $years=range(now()->year-2, now()->year+1);
        @endphp
        <select name="month" class="sel">
          @foreach($months as $i=>$m)
            <option value="{{ $i }}" @selected($i==$month)>{{ $m }}</option>
          @endforeach
        </select>
        <select name="year" class="sel">
          @foreach($years as $y)
            <option value="{{ $y }}" @selected($y==$year)>{{ $y }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn">Terapkan</button>
      </form>

      {{-- Tabel riwayat --}}
      <table class="absensi">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>ID</th>
            <th>Nama</th>
            <th>Shift</th>
            <th>Jam Masuk</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($riwayat as $r)
            <tr>
              <td>{{ $r->tanggal->format('d/m/Y') }}</td>
              <td>{{ $r->user->id }}</td>
              <td style="text-align:left">{{ $r->user->name }}</td>
              <td>{{ $r->shift ?? '-' }}</td>
              <td>
                {{ $r->jam_masuk ? \Illuminate\Support\Carbon::parse($r->jam_masuk)->format('H:i') : '-' }}
              </td>
              <td>
                @php
                  $map = [
                    'Hadir'     => ['hadir','Hadir'],
                    'Alfa'      => ['alfa','Alfa'],
                    'Izin'      => ['izin','Izin'],
                    'Terlambat' => ['terlambat','Terlambat'],
                  ];
                  [$cls,$lbl] = $map[$r->status] ?? ['','-'];
                @endphp
                @if($cls)
                  <span class="dot {{ $cls }}" title="{{ $lbl }}"></span>
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">Belum ada data untuk {{ $labelBulan }}.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

    </div>
  </div>
</div>
@endsection
