@extends('layouts.auth-shop')
@section('title','Đăng nhập')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h3 class="fw-bold mb-1">Đăng nhập</h3>
    <div class="muted">Chào mừng bạn quay lại 👋</div>
  </div>
  <a class="btn btn-outline-dark rounded-pill px-3" href="{{ route('register') }}">
    Đăng ký
  </a>
</div>

@if (session('status'))
  <div class="alert alert-success rounded-4">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
  @csrf

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}" required autofocus autocomplete="username">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Mật khẩu</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
           required autocomplete="current-password">
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
      <label class="form-check-label muted" for="remember_me">Ghi nhớ đăng nhập</label>
    </div>

    @if (Route::has('password.request'))
      <a class="muted" href="{{ route('password.request') }}">Quên mật khẩu?</a>
    @endif
  </div>

  <button class="btn btn-brand text-white w-100 rounded-pill py-2 fw-semibold">
    <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
  </button>

  <div class="text-center mt-3 muted">
    Chưa có tài khoản? <a href="{{ route('register') }}"><b>Đăng ký</b></a>
  </div>
</form>
@endsection