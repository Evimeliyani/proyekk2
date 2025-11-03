@extends('layouts.auth')
@section('title','Tambah Karyawan')

@section('content')
<style>
  body,html{margin:0;padding:0;width:100%;overflow-x:hidden;background:#f6f6f6;}
  .page-wrap{width:100vw;min-height:100vh;display:flex;flex-direction:column;}

  /* ==== kunci: full-bleed buat keluar dari container layout ==== */
  .full-bleed{
    width:100vw;
    margin-left:calc(50% - 50vw);
    margin-right:calc(50% - 50vw);
    padding-left:50px;   /* ruang kiri-kanan */
    padding-right:50px;
  }

  .topbar{
    background:#8fb3bb;
    color:#0a2a30;
    font-weight:700;
    padding:14px 40px;
    font-size:1.1rem;
    box-shadow:0 1px 4px rgba(0,0,0,0.1);
  }

  /* konten benar2 penuh, tanpa max-width */
  .content{
    flex:1;
    width:100%;
    padding:30px 0;   /* padding horizontal sudah di .full-bleed */
    margin:0;
    max-width:none;
  }

  .card{
    background:#ffffff;
    border-radius:14px;
    border:1px solid #d8d8d8;
    padding:26px 32px;
    box-shadow:0 4px 8px rgba(0,0,0,0.08);
    width:100%;        /* isi selebar area */
    max-width:none;     /* jangan dibatasi */
  }

  h3{margin:0 0 20px;color:#1f3c40;font-size:1.3rem}
  label{display:block;margin-bottom:4px;font-weight:600;color:#1e3a3e}
  input, select{
    width:100%;
    border:1px solid #ccc;
    border-radius:8px;
    padding:10px 12px;
    margin-top:4px;
    font-size:.95rem;
  }
  button, a.button-cancel{
    display:inline-block;
    padding:10px 18px;
    border:none;
    border-radius:8px;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
    font-size:.95rem;
  }
  button{background:#2a4d52;color:#fff}
  a.button-cancel{background:#ddd;color:#222;margin-left:8px}
  button:hover{opacity:.9}
  a.button-cancel:hover{background:#ccc}

  @media (max-width: 900px){
    .full-bleed{padding-left:16px;padding-right:16px}
  }
</style>

<div class="page-wrap">

  <div class="full-bleed">
    <div class="content">
      <div class="card">
        <h3>＋ Tambah Karyawan</h3>
        <form method="POST" action="{{ route('admin.karyawan.store') }}">
          @csrf
          <div style="margin-bottom:14px">
            <label>UID</label>
            <input name="uid" value="{{ old('uid') }}" required>
          </div>
          <div style="margin-bottom:14px">
            <label>Nama</label>
            <input name="name" value="{{ old('name') }}" required>
          </div>
          <div style="margin-bottom:14px">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
          </div>
          <div style="margin-bottom:14px">
            <label>Password (min 6)</label>
            <input type="password" name="password" required>
          </div>
          <div style="margin-bottom:14px">
            <label>Alamat</label>
            <input name="alamat" value="{{ old('alamat') }}">
          </div>
          <div style="margin-bottom:20px">
            <label>Status</label>
            <select name="status">
              <option value="aktif">Aktif</option>
              <option value="cuti">Cuti</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>
          <button type="submit">Simpan</button>
          <a href="{{ route('admin.karyawan.index') }}" class="button-cancel">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
