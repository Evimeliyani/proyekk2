@extends('layouts.admin')
@section('title','Data Karyawan')

@section('content')
<div class="card">

  <h2 style="margin-bottom:12px">👥 Data Karyawan</h2>

  {{-- Tampilkan pesan sukses --}}
  @if(session('ok'))
    <div style="background:#e6ffed;border:1px solid #2ecc71;color:#2d7a46;
                padding:8px 12px;border-radius:8px;margin-bottom:12px">
      {{ session('ok') }}
    </div>
  @endif

  <a href="{{ route('admin.karyawan.create') }}"
     style="background:#2a4d52;color:#fff;border:none;
            padding:8px 14px;border-radius:8px;text-decoration:none;
            display:inline-block;margin-bottom:12px">
     ➕ Tambah Karyawan
  </a>

  <table width="100%" border="1" cellpadding="10" cellspacing="0"
         style="border-collapse:collapse">
    <thead style="background:#547d80;color:#fff">
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
          @php $status = $u->karyawan->status ?? 'aktif'; @endphp
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
        <td>
          <a href="{{ route('admin.karyawan.edit',$u->id) }}"
             style="padding:6px 10px;border-radius:6px;
                    background:#6f9698;color:#fff;text-decoration:none">
            Edit
          </a>

          <form action="{{ route('admin.karyawan.destroy',$u->id) }}"
                method="POST" style="display:inline"
                onsubmit="return confirm('Hapus karyawan ini?')">
            @csrf @method('DELETE')
            <button type="submit"
                    style="padding:6px 10px;border-radius:6px;
                           background:#dc3545;color:#fff;border:none">
              Hapus
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;color:#999">
          Belum ada data karyawan
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

</div>
@endsection
