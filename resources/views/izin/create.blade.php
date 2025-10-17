@extends('layouts.auth')
@section('title','Ajukan Izin')

@push('styles')
<style>
  :root{
    --header:#8fb3bb; --panel:#c8d8d0; --card:#b7cabe; --ink:#2a4d52;
  }
  .i-wrap{min-height:100dvh;background:var(--panel);padding:24px}
  .i-header{background:var(--header);border-radius:8px 8px 0 0;
            padding:16px 28px;display:flex;align-items:center;color:#fff;
            max-width:1200px;margin:0 auto}
  .i-back{margin-right:14px;font-size:22px;color:#fff;text-decoration:none}
  .i-avatar{width:50px;height:50px;border-radius:50%;background:#ddd;margin-left:auto}
  .i-info{margin-left:12px}
  .i-info .name{font-weight:600;font-size:18px;color:#fff}
  .i-info .role{font-size:13px;opacity:.9}

  .i-card{background:var(--card);border-radius:0 0 8px 8px;
          padding:30px;max-width:1200px;margin:0 auto}
  .i-card label{display:block;margin-bottom:6px;color:#222;font-size:14px}
  .i-card input,.i-card select,.i-card textarea{
      width:100%;padding:12px;border:none;background:#e2e2e2;
      border-radius:6px;margin-bottom:16px;font-size:15px
  }
  .i-card button{background:var(--ink);color:#fff;border:none;
                 padding:10px 24px;border-radius:8px;display:block;
                 margin:18px auto 0;cursor:pointer;font-size:15px}

  /* supaya ada breathing room di layar besar */
  @media (min-width:1400px){
    .i-header, .i-card{max-width:1400px}
  }
</style>
@endpush

@section('content')
<div class="i-wrap">
  {{-- Header --}}
  <div class="i-header">
    <a href="{{ route('karyawan.dashboard') }}" class="i-back">←</a>
    <div class="i-info">
      <div class="name">{{ auth()->user()->name }}</div>
      <div class="role">Karyawan</div>
    </div>
    <div class="i-avatar"></div>
  </div>

  {{-- Form Card --}}
  <div class="i-card">
    <form method="POST" action="{{ route('izin.store') }}">
      @csrf

      <label>Nama</label>
      <input type="text" value="{{ auth()->user()->name }}" readonly>

      <label>Tanggal izin</label>
      <input type="date" name="tanggal_izin" value="{{ old('tanggal_izin') }}" required>

      <label>Jenis Izin</label>
      <select name="jenis_izin" required>
        <option value="">-- Pilih Jenis Izin --</option>
        <option value="Sakit" {{ old('jenis_izin')=='Sakit'?'selected':'' }}>Sakit</option>
        <option value="Cuti" {{ old('jenis_izin')=='Cuti'?'selected':'' }}>Cuti</option>
        <option value="Izin Pribadi" {{ old('jenis_izin')=='Izin Pribadi'?'selected':'' }}>Izin Pribadi</option>
      </select>

      <label>Alasan</label>
      <textarea name="alasan" rows="3" required>{{ old('alasan') }}</textarea>

      <button type="submit">Kirim</button>
    </form>
  </div>
</div>
@endsection
