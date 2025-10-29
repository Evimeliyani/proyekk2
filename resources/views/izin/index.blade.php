@extends('layouts.auth')
@section('title','Persetujuan Izin')

@section('content')
<div style="padding:20px">
  <h2>Persetujuan Izin</h2>

  @if(session('ok'))
    <div style="margin:10px 0;padding:8px 12px;background:#e6ffed;border:1px solid #b7ebc6;border-radius:8px;color:#20572f">
      {{ session('ok') }}
    </div>
  @endif

  <table style="width:100%;border-collapse:collapse;background:#fff;margin-top:12px">
    <thead>
      <tr style="background:#f5f5f5">
        <th style="border:1px solid #e6e6e6;padding:8px">ID</th>
        <th style="border:1px solid #e6e6e6;padding:8px">Nama</th>
        <th style="border:1px solid #e6e6e6;padding:8px">Tanggal</th>
        <th style="border:1px solid #e6e6e6;padding:8px">Jenis</th>
        <th style="border:1px solid #e6e6e6;padding:8px">Alasan</th>
        <th style="border:1px solid #e6e6e6;padding:8px">Status</th>
        <th style="border:1px solid #e6e6e6;padding:8px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($izin as $i)
      <tr>
        <td style="border:1px solid #e6e6e6;padding:8px;text-align:center">{{ $i->id }}</td>
        <td style="border:1px solid #e6e6e6;padding:8px">{{ $i->user->name }}</td>
        <td style="border:1px solid #e6e6e6;padding:8px;text-align:center">{{ \Carbon\Carbon::parse($i->tanggal_izin)->format('d/m/Y') }}</td>
        <td style="border:1px solid #e6e6e6;padding:8px;text-align:center">{{ $i->jenis_izin }}</td>
        <td style="border:1px solid #e6e6e6;padding:8px">{{ $i->alasan }}</td>
        <td style="border:1px solid #e6e6e6;padding:8px;text-transform:capitalize;text-align:center">{{ $i->status }}</td>
        <td style="border:1px solid #e6e6e6;padding:8px;text-align:center">
          @if($i->status === 'pending')
            <form action="{{ route('izin.approve', $i) }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" style="padding:6px 10px;border:0;border-radius:8px;background:#2a4d52;color:#fff">Approve</button>
            </form>
            <form action="{{ route('izin.reject', $i) }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" style="padding:6px 10px;border:0;border-radius:8px;background:#ff3b30;color:#fff">Reject</button>
            </form>
          @else
            ({{ $i->status }})
          @endif
        </td>
      </tr>
      @empty
        <tr>
          <td colspan="7" style="border:1px solid #e6e6e6;padding:10px;text-align:center">
            Belum ada pengajuan izin.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
