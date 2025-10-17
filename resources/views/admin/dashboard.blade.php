@extends('layouts.auth')
@section('title','Admin Dashboard')
@section('content')
<div class="auth-wrap" style="display:flex;align-items:center;justify-content:center;height:320px">
  <div style="text-align:center">
    <h2 class="title">Admin Dashboard</h2>
    <p>Halo {{ auth()->user()->name }}, ini halaman admin.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn">Logout</button>
    </form>
  </div>
</div>
@endsection