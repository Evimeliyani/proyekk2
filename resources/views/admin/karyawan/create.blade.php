@extends('layouts.auth')
@section('title','Tambah Karyawan')

@section('content')
<div style="padding:18px 22px;max-width:620px">
  <h3 style="margin:0 0 12px;color:#1f3c40">＋ Tambah Karyawan</h3>
  <form method="POST" action="{{ route('admin.karyawan.store') }}">
    @csrf
    <div style="margin-bottom:10px"><label>UID</label>
      <input name="uid" value="{{ old('uid') }}" required></div>
    <div style="margin-bottom:10px"><label>Nama</label>
      <input name="name" value="{{ old('name') }}" required></div>
    <div style="margin-bottom:10px"><label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required></div>
    <div style="margin-bottom:10px"><label>Password (min 6)</label>
      <input type="password" name="password" required></div>
    <div style="margin-bottom:10px"><label>Alamat</label>
      <input name="alamat" value="{{ old('alamat') }}"></div>
    <div style="margin-bottom:16px"><label>Status</label>
      <select name="status">
        <option value="aktif">Aktif</option>
        <option value="cuti">Cuti</option>
        <option value="nonaktif">Nonaktif</option>
      </select>
    </div>
    <button type="submit">Simpan</button>
    <a href="{{ route('admin.karyawan.index') }}">Batal</a>
  </form>
</div>
@endsection
