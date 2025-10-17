@extends('layouts.auth')

@section('title','Login')

@section('content')
<div class="auth-wrap">
  <div class="left" aria-hidden="true"></div>

  <div class="right">
    <div class="card">
      <h1 class="title">Selamat Datang</h1>

      @if ($errors->any())
        <div class="error">
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('login.attempt') }}" novalidate>
        @csrf

        <div class="field">
          <input type="text" name="name" placeholder="Name (opsional)" value="{{ old('name') }}">
        </div>

        <div class="field">
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="row">
          <label style="display:flex;gap:8px;align-items:center;color:#2a4d52;font-size:13px;">
            <input type="checkbox" name="remember" value="1"> Remember me
          </label>
          <button class="btn" type="submit">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
