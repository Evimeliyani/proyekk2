@extends('layouts.auth')
@section('title','Pengajuan Izin Terkirim')

@section('content')
<div class="k-wrap" style="padding:32px">
  <div class="k-card" style="max-width:700px;margin:0 auto">
    <h2 style="margin:0 0 10px;color:#2a4d52">Pengajuan Izin Terkirim 🎉</h2>
    <p style="margin:0 0 16px;color:#355">Terima kasih, pengajuan kamu sudah kami terima dan berstatus <b>{{ strtoupper($izin->status) }}</b>.</p>

    <div style="background:#eef7f0;border:1px solid #d7e7da;border-radius:10px;padding:14px 16px;margin-bottom:16px">
      <div><b>Nama</b>: {{ $izin->user->name }}</div>
      <div><b>Tanggal Izin</b>: {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</div>
      <div><b>Jenis Izin</b>: {{ $izin->jenis_izin }}</div>
      <div><b>Alasan</b>: {{ $izin->alasan }}</div>
      <div><b>Diajukan</b>: {{ $izin->created_at->format('d M Y H:i') }}</div>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap">
      <a href="{{ route('karyawan.dashboard') }}" class="btn" style="text-align:center">Kembali ke Dashboard</a>
      {{-- kalau pakai riwayat izin, aktifkan tombol di bawah --}}
      {{-- <a href="{{ route('izin.index') }}" class="btn" style="background:#0b665f;text-align:center">Lihat Riwayat Izin</a> --}}
    </div>
  </div>
</div>
@endsection
