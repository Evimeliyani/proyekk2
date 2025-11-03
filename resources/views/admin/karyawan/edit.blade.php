@extends('layouts.auth')
@section('title','Edit Karyawan')

@section('content')
<style>
  :root{
    --bg:#f6f6f6;
    --card:#ffffff;
    --ink:#1f3c40;
    --line:#d9d9d9;
    --line-dark:#bfbfbf;
    --shadow:0 8px 18px rgba(0,0,0,.06);
    --btn:#1f4d4a;      /* hijau gelap seperti contoh tombol "Simpan" */
    --btn-ghost:#e0e0e0;
    --radius:12px;
  }

  body,html{background:var(--bg);margin:0;padding:0;overflow-x:hidden}

  /* trik full-bleed supaya keluar dari container layouts.auth (UI only) */
  .full-bleed{
    width:100vw;
    margin-left:calc(50% - 50vw);
    margin-right:calc(50% - 50vw);
    padding-left:28px;
    padding-right:28px;
  }

  .section{padding:18px 0}

  .card-wide{
    background:var(--card);
    border:1px solid #ececec;
    border-radius:16px;
    box-shadow:var(--shadow);
    padding:22px 26px;
    width:100%;
  }

  /* heading mirip gaya contoh */
  .heading{
    display:flex;align-items:center;gap:10px;
    margin:4px 0 16px;color:var(--ink);
    font-weight:800;font-size:20px;
  }
  .heading::before{
    content:'✎';
    display:inline-grid;place-items:center;
    width:28px;height:28px;border-radius:8px;
    background:#eef6f6;color:#1f4d4a;font-weight:700;
  }

  /* form lebar, input besar & rapi */
  .field{margin-bottom:16px}
  label{display:block;margin-bottom:6px;color:#143637;font-weight:700}
  input[type="text"], input[type="email"], input[type="password"], select{
    width:100%;
    border:1px solid var(--line);
    border-radius:10px;
    padding:12px 14px;
    font-size:16px;
    background:#fff;
    transition:border-color .15s, box-shadow .15s;
  }
  input:focus, select:focus{
    outline:none;
    border-color:var(--line-dark);
    box-shadow:0 0 0 4px rgba(31,77,74,.08);
  }

  /* alert error rapi */
  .alert{
    background:#fff1f0;border:1px solid #ffa39e;color:#a8071a;
    padding:10px 12px;border-radius:10px;margin-bottom:14px
  }

  /* actions */
  .actions{display:flex;gap:10px;align-items:center;margin-top:6px}
  .btn{
    border:none;border-radius:10px;padding:10px 16px;cursor:pointer;
    font-weight:700;font-size:15px;text-decoration:none;display:inline-block;
  }
  .btn-primary{background:var(--btn);color:#fff}
  .btn-ghost{background:var(--btn-ghost);color:#222}

  @media (min-width:1200px){
    .card-wide{padding:24px 28px}
  }
</style>

<div class="full-bleed section">
  <div class="card-wide">
    <h3 class="heading">Edit Karyawan</h3>

    @if ($errors->any())
      <div class="alert">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('admin.karyawan.update', $user->id) }}">
      @csrf @method('PUT')

      <div class="field">
        <label>UID</label>
        <input name="uid" value="{{ old('uid', $user->karyawan->uid ?? '') }}" required>
      </div>

      <div class="field">
        <label>Nama</label>
        <input name="name" value="{{ old('name', $user->name) }}" required>
      </div>

      <div class="field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
      </div>

      <div class="field">
        <label>Password (kosongkan jika tidak ganti)</label>
        <input type="password" name="password">
      </div>

      <div class="field">
        <label>Alamat</label>
        <input name="alamat" value="{{ old('alamat', $user->karyawan->alamat ?? '') }}">
      </div>

      <div class="field" style="margin-bottom:18px">
        <label>Status</label>
        @php $st = old('status', $user->karyawan->status ?? 'aktif'); @endphp
        <select name="status">
          <option value="aktif" {{ $st=='aktif'?'selected':'' }}>Aktif</option>
          <option value="cuti" {{ $st=='cuti'?'selected':'' }}>Cuti</option>
          <option value="nonaktif" {{ $st=='nonaktif'?'selected':'' }}>Nonaktif</option>
        </select>
      </div>

      <div class="actions">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-ghost">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
