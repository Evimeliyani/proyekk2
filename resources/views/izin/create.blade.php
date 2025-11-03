@extends('layouts.auth')
@section('title','Ajukan Izin')

@push('styles')
<style>
  :root{
    --header:#8fb3bb;
    --panel:#c8d8d0;
    --card:#b7cabe;
    --ink:#2a4d52;
  }

  body,html{
    margin:0;padding:0;width:100%;height:100%;
    overflow-x:hidden;background:var(--panel);
  }

  /* full width keluar dari container layout */
  .full-bleed{
    width:100vw;
    margin-left:calc(50% - 50vw);
    margin-right:calc(50% - 50vw);
  }

  .i-wrap{
    min-height:100dvh;
    background:var(--panel);
    padding:40px 60px;
  }

  /* header full width */
  .i-header{
    background:var(--header);
    border-radius:10px 10px 0 0;
    padding:20px 36px;
    display:flex;
    align-items:center;
    color:#fff;
    width:100%;
    box-shadow:0 3px 6px rgba(0,0,0,.15);
  }
  .i-back{
    margin-right:18px;
    font-size:24px;
    color:#fff;
    text-decoration:none;
    transition:opacity .2s;
  }
  .i-back:hover{opacity:.8}
  .i-info{margin-left:12px}
  .i-info .name{font-weight:700;font-size:20px;color:#fff}
  .i-info .role{font-size:13px;opacity:.9}
  .i-avatar{
    width:60px;height:60px;border-radius:50%;
    background:#e5e5e5;margin-left:auto;
    border:2px solid #fff;
    box-shadow:0 0 0 2px rgba(0,0,0,.1);
  }

  /* form card full width juga */
  .i-card{
    background:var(--card);
    border-radius:0 0 10px 10px;
    padding:40px 50px;
    width:100%;
    box-shadow:0 6px 14px rgba(0,0,0,.1);
    border:1px solid rgba(0,0,0,.06);
  }

  .i-card label{
    display:block;
    margin-bottom:6px;
    color:#222;
    font-size:15px;
    font-weight:600;
  }

  .i-card input,
  .i-card select,
  .i-card textarea{
    width:100%;
    padding:12px 14px;
    border:none;
    background:#e2e2e2;
    border-radius:8px;
    margin-bottom:18px;
    font-size:16px;
    transition:background .2s;
  }
  .i-card input:focus,
  .i-card select:focus,
  .i-card textarea:focus{
    outline:none;
    background:#f0f0f0;
  }

  .i-card button{
    background:var(--ink);
    color:#fff;
    border:none;
    padding:12px 36px;
    border-radius:8px;
    display:block;
    margin:24px auto 0;
    cursor:pointer;
    font-size:16px;
    font-weight:700;
    transition:background .2s;
  }
  .i-card button:hover{
    background:#1c3d40;
  }

  @media (max-width:900px){
    .i-wrap{padding:20px}
    .i-card{padding:28px 20px}
    .i-header{padding:16px 20px}
  }
</style>
@endpush

@section('content')
<div class="full-bleed">
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

        <label>Tanggal Izin</label>
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
</div>
@endsection
