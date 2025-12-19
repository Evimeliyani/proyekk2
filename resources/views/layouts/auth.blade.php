<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Login')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root{
      --bg: #9fb8ba;     /* warna biru keabu UI */
      --field: #4f6a6e;  /* warna field */
      --field-text:#e6f0f1;
      --btn: #3c5960;
      --btn-text:#ecf5f6;
      --ring:#1583ff;
    }
    *{box-sizing:border-box}
    body{
      margin:0; font-family: system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,'Helvetica Neue',Arial,'Apple Color Emoji','Segoe UI Emoji';
      background: var(--bg);
      min-height:100svh; display:grid; place-items:center;
    }
    .auth-wrap{
      width:min(980px, 94vw); height:560px; background:#b6cacc;
      border:4px solid #fff; border-radius:10px; overflow:hidden; position:relative;
      box-shadow:0 20px 40px rgba(0,0,0,.12);
    }
    .left{
      position:absolute; inset:0; width:56%;
      background:#ccc url("{{ asset('images/login.jpg') }}") center/cover no-repeat;
      clip-path: circle(74% at 0% 50%);
      border-right:4px solid var(--ring);
    }
    .right{
      position:absolute; right:0; top:0; bottom:0; width:44%;
      display:flex; align-items:center; justify-content:center; padding-inline:28px;
    }
    .card{ width:100%; max-width:360px }
    .title{ color:#23464b; letter-spacing:.3px; margin:0 0 24px; font-weight:700; font-size:26px }
    .field{ margin-bottom:14px }
    .field input{
      width:100%; border:none; border-radius:6px; background:var(--field); color:var(--field-text);
      padding:12px 14px; font-size:14px; outline:none;
      box-shadow:inset 0 0 0 1.5px rgba(0,0,0,.05)
    }
    .field input::placeholder{ color:#d7e6e7 }
    .field input:focus{ outline: 3px solid var(--ring); }
    .row{ display:flex; align-items:center; justify-content:space-between; margin-top:6px; }
    .btn{
      display:inline-block; border:none; background:var(--btn); color:var(--btn-text);
      padding:10px 22px; border-radius:8px; font-weight:600; cursor:pointer
    }
    .error{
      margin:6px 0 0; font-size:12px; color:#173; color:#7a1c1c; background:#ffeaea; border:1px solid #ffc7c7; padding:8px 10px; border-radius:6px
    }
    .logout{ position:fixed; right:14px; top:14px; }
    @media (max-width:860px){
      .left{ display:none }
      .right{ position:relative; width:100% }
      .auth-wrap{ height:auto; padding:32px 18px }
    }
  </style>
  @stack('head')
  @stack('styles')
</head>
<body>
  @yield('content')
  @stack('scripts')
</body>
</html>