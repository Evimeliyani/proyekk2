@extends('layouts.admin')
@section('title','Presensi Harian')

@section('content')
<div style="background:#f6efe8;padding:20px;border-radius:12px">

  <!-- HEADER PRESENSI -->
  <div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:16px;
    gap:12px;
    flex-wrap:wrap;
  ">
    <h2 style="margin:0">📋 Presensi Harian</h2>

    <form method="GET"
          action="{{ route('admin.presensi.index') }}"
          style="display:flex;gap:8px;align-items:center">

      <!-- PILIH TANGGAL -->
      <input type="date"
             name="tanggal"
             value="{{ $tanggal }}"
             style="
               padding:6px 10px;
               border-radius:8px;
               border:1px solid #ccc
             ">

      <!-- TOMBOL FILTER -->
      <button type="submit"
              style="
                padding:6px 14px;
                background:#2a4d52;
                color:#fff;
                border:none;
                border-radius:8px;
                cursor:pointer
              ">
        🔍 Tampilkan
      </button>

      <!-- TOMBOL CETAK -->
      <a href="{{ route('admin.presensi.cetak', ['tanggal'=>$tanggal]) }}"
         target="_blank"
         style="
           padding:6px 14px;
           background:#4f7779;
           color:#fff;
           text-decoration:none;
           border-radius:8px
         ">
        🖨️ Cetak PDF
      </a>
    </form>
  </div>

  <!-- TABEL PRESENSI (TIDAK DIUBAH) -->
  <table width="100%" border="1" cellpadding="10" cellspacing="0">
    <thead style="background:#4f7779;color:#fff">
      <tr>
        <th>UID</th>
        <th>Nama</th>
        <th>Jam Masuk</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
      <tr>
        <td>{{ $r['uid'] }}</td>
        <td>{{ $r['nama'] }}</td>
        <td>{{ $r['jam'] }}</td>
        <td>
          @if($r['status']=='Hadir')
            ✔ Hadir
          @elseif($r['status']=='Terlambat')
            ⚠ Terlambat
          @else
            ❌ Alfa
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div>
@endsection

@push('scripts')
<script>
var lastUID = null;

function cekRFID() {
    fetch("{{ route('scan.presensi') }}")
        .then(res => res.json())
        .then(data => {
            if (!data || !data.uid) return;
            if (data.uid === lastUID) return;

            lastUID = data.uid;
            location.reload();
        })
        .catch(err => console.log(err));
}

setInterval(cekRFID, 2000);
</script>
@endpush
