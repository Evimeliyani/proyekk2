@extends('layouts.auth')
@section('title','Data Karyawan')

@section('content')
<div style="padding:20px">
  <h2 style="margin-bottom:12px">👥 Data Karyawan</h2>

  {{-- Tampilkan pesan sukses --}}
  @if(session('ok'))
    <div style="background:#e6ffed;border:1px solid #2ecc71;color:#2d7a46;padding:8px 12px;border-radius:8px;margin-bottom:12px">
      {{ session('ok') }}
    </div>
  @endif

  <a href="{{ route('admin.karyawan.create') }}" 
     style="background:#2a4d52;color:#fff;border:none;padding:8px 14px;border-radius:8px;text-decoration:none">
     ➕ Tambah Karyawan
  </a>

  <table border="1" cellpadding="8" cellspacing="0" style="margin-top:14px;width:100%;border-collapse:collapse">
    <thead style="background:#f0f5f4">
      <tr>
        <th>ID</th>
        <th>UID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $u)
      <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->karyawan->uid ?? '-' }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->karyawan->alamat ?? '-' }}</td>
        <td>
          @php
            $status = $u->karyawan->status ?? 'aktif';
          @endphp
          <span style="
            padding:4px 8px;
            border-radius:6px;
            color:#fff;
            background:
              {{ $status=='aktif' ? '#28a745' : ($status=='cuti' ? '#f0ad4e' : '#dc3545') }};
          ">
            {{ ucfirst($status) }}
          </span>
        </td>
        <td class="actions">
          <a href="{{ route('admin.karyawan.edit', $u->id) }}" class="btn outline">Edit</a>
          <form action="{{ route('admin.karyawan.destroy', $u->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus karyawan ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn outline">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;color:#999">Belum ada data karyawan</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
