@extends('layouts.auth')
@section('title','Edit Karyawan')

@section('content')
<div style="padding:18px 22px;max-width:620px">
  <h3 style="margin:0 0 12px;color:#1f3c40">✎ Edit Karyawan</h3>

  @if ($errors->any())
    <div style="background:#fff1f0;border:1px solid #ffa39e;color:#a8071a;padding:8px 12px;border-radius:8px;margin-bottom:10px">
      @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('admin.karyawan.update', $user->id) }}">
    @csrf @method('PUT')

    <div style="margin-bottom:10px">
      <label>UID</label><br>
      <input name="uid" value="{{ old('uid', $user->karyawan->uid ?? '') }}" required>
    </div>

    <div style="margin-bottom:10px">
      <label>Nama</label><br>
      <input name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div style="margin-bottom:10px">
      <label>Email</label><br>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div style="margin-bottom:10px">
      <label>Password (kosongkan jika tidak ganti)</label><br>
      <input type="password" name="password">
    </div>

    <div style="margin-bottom:10px">
      <label>Alamat</label><br>
      <input name="alamat" value="{{ old('alamat', $user->karyawan->alamat ?? '') }}">
    </div>

    <div style="margin-bottom:16px">
      <label>Status</label><br>
      @php $st = old('status', $user->karyawan->status ?? 'aktif'); @endphp
      <select name="status">
        <option value="aktif" {{ $st=='aktif'?'selected':'' }}>Aktif</option>
        <option value="cuti" {{ $st=='cuti'?'selected':'' }}>Cuti</option>
        <option value="nonaktif" {{ $st=='nonaktif'?'selected':'' }}>Nonaktif</option>
      </select>
    </div>

    <button type="submit" style="background:#2a4d52;color:#fff;border:none;border-radius:8px;padding:8px 12px">Update</button>
    <a href="{{ route('admin.karyawan.index') }}" class="btn outline" style="margin-left:8px">Kembali</a>
  </form>
</div>
@endsection
