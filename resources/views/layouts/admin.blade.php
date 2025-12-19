<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>@yield('title','Admin')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    body{
      margin:0;
      font-family: Arial, sans-serif;
      background:#e6efef;
    }

    .admin-layout{
      display:flex;
      min-height:100vh;
    }

    /* SIDEBAR */
    .sidebar{
      width:260px;
      background:#547d80;
      color:#fff;
      padding:20px;
    }

    .profile{
      text-align:center;
      margin-bottom:30px;
    }

    .avatar{
      width:90px;
      height:90px;
      background:#ddd;
      border-radius:50%;
      margin:0 auto 10px;
    }

    .profile .name{
      font-size:18px;
      font-weight:bold;
    }

    .profile .edit{
      font-size:13px;
      color:#dfeeee;
      text-decoration:none;
    }

    .menu a{
      display:flex;
      align-items:center;
      gap:10px;
      padding:12px 14px;
      margin-bottom:10px;
      border-radius:10px;
      color:#fff;
      text-decoration:none;
      background:rgba(255,255,255,0.12);
    }

    .menu a.active,
    .menu a:hover{
      background:#6f9698;
    }

    /* KONTEN KANAN */
    .content{
      flex:1;
      padding:30px;
      background:#f6efe8;
    }
  </style>

  @stack('styles')
</head>
<body>

<div class="admin-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="profile">
      <div class="avatar"></div>
      <div class="name">{{ auth()->user()->name }}</div>
      <a href="#" class="edit">Edit</a>
    </div>

    <nav class="menu">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
      <a href="{{ route('admin.karyawan.index') }}" class="{{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">👥 Data Karyawan</a>
      <a href="{{ route('admin.presensi.index') }}" class="{{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}">📋 Presensi Harian</a>
      <a href="{{ route('admin.laporan.index') }}">📊 Laporan</a>
      <a href="{{ route('izin.index') }}">✅ Persetujuan Izin</a>
    </nav>
  </aside>

  <!-- KONTEN -->
  <main class="content">
    @yield('content')
  </main>

</div>

@stack('scripts')
</body>
</html>
