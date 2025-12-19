@extends('layouts.admin')
@section('title','Presensi Harian')

@section('content')
<div style="background:#f6efe8;padding:20px;border-radius:12px">


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
        .then(function(res) {
            return res.json();
        })
        .then(function(data) {
            if (!data || !data.uid) return;

            if (data.uid === lastUID) return;
            lastUID = data.uid;

            console.log('SCAN:', data);
            location.reload();
        })
        .catch(function(err) {
            console.log('scan error', err);
        });
}

setInterval(cekRFID, 2000);
</script>
@endpush