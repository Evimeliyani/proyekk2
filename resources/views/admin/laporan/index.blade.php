@extends('layouts.admin')
@section('title','Laporan')

@push('styles')
<style>
  :root{
    --bg:#deeae2; --panel:#e9f0ea; --header:#8fb3bb; --ink:#2a4d52;
  }


  .lap-wrap{min-height:100dvh;background:var(--panel);padding:0}
  .r-header{
    background:var(--header);
    color:#0a2a30;
    padding:14px 24px;
    display:flex;
    align-items:center;
    gap:10px
  }

  .lap-card{background:#fff;border-radius:14px;padding:16px;border:1px solid #dcdcdc}
  .lap-title{display:flex;align-items:center;gap:8px;font-weight:600}
  .lap-toolbar{margin-left:auto;display:flex;gap:8px;align-items:center}
  .lap-select{display:flex;align-items:center;gap:8px;background:#2a4d52;color:#fff;border-radius:10px;padding:6px 10px}
  .lap-select select{background:transparent;border:none;color:#fff;outline:none;appearance:none;cursor:pointer}
  .lap-select select option{color:#000;background:#fff}
  .lap-btn{background:#2a4d52;color:#fff;border:none;border-radius:10px;padding:6px 10px;cursor:pointer}
  .lap-container{width:100%;padding:16px 24px}

  /* tabel full & semua kolom rata tengah */
  .lap-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    border:1px solid #dcdcdc;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 14px rgba(0,0,0,.08);
  }
  .lap-table th,.lap-table td{
    padding:12px 14px;
    border-bottom:1px solid #e9e9e9;
    color:var(--ink);
    text-align:center;          /* semua kolom tengah */
    vertical-align:middle;
  }
  .lap-table thead th{background:#f6f6f6;font-weight:600}
  .lap-table tr:nth-child(even){background:#fafafa}
  .lap-badge{font-weight:600;display:inline-block;min-width:40px;text-align:center}
  .lap-scroll{overflow:auto;border-radius:12px}

  @media print{
    .lap-toolbar,.sidebar,.navbar{display:none!important}
    .lap-wrap{background:#fff}
    .lap-card{border:none;padding:0}
    .r-header{padding:0 0 8px 0}
    .lap-container{padding:0}
  }
</style>
@endpush

@section('content')
<div class="lap-wrap full-bleed">
  <div class="r-header">
    <div class="lap-title">📄 Laporan</div>
    <div class="lap-toolbar">
      <form id="monthForm" method="GET" action="{{ route('admin.laporan.index') }}" class="lap-select">
        <span>▾</span>
        @php
          $bulanMap = [
            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
            '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
          ];
          [$curYear,$curMonth] = explode('-', $monthStr);
          $curMonth = str_pad($curMonth,2,'0',STR_PAD_LEFT);
          $yearNow=(int)now()->format('Y');$startYear=2023;$endYear=$yearNow+1;
        @endphp
        <select name="m" id="selBulan">
          @foreach($bulanMap as $mm=>$namaBln)
            <option value="{{(int)$mm}}" {{ $curMonth===$mm?'selected':'' }}>{{ $namaBln }}</option>
          @endforeach
        </select>
        <select name="year" id="selTahun">
          @for($y=$endYear;$y>=$startYear;$y--)
            <option value="{{$y}}" {{ (string)$y===(string)$curYear?'selected':'' }}>{{$y}}</option>
          @endfor
        </select>
      </form>
      <button class="lap-btn" id="btnPrint">🖨️ Cetak</button>
    </div>
  </div>

  <div class="lap-container">
    <div class="lap-card">
      <div class="lap-scroll">
        <table class="lap-table">
          <thead>
            <tr>
              <th>UID</th>
              <th>Nama</th>
              <th>Hadir</th>
              <th>Izin</th>
              <th>Alfa</th>
              <th>Total Kerja</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
              <tr>
                <td>{{ $r->uid }}</td>
                <td>{{ $r->nama }}</td>
                <td><span class="lap-badge" style="color:#25c23a">{{ $r->hadir }}</span></td>
                <td><span class="lap-badge" style="color:#f6b200">{{ $r->izin }}</span></td>
                <td><span class="lap-badge" style="color:#ff3b30">{{ $r->alfa }}</span></td>
                <td><span class="lap-badge">{{ $r->totalKerja }}</span></td>
              </tr>
            @empty
              <tr><td colspan="6" style="text-align:center;color:#777">Belum ada data.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const form=document.getElementById('monthForm');
  const selBulan=document.getElementById('selBulan');
  const selTahun=document.getElementById('selTahun');
  selBulan.addEventListener('change',()=>form.submit());
  selTahun.addEventListener('change',()=>form.submit());
  document.getElementById('btnPrint').addEventListener('click',()=>window.print());
</script>
@endpush
