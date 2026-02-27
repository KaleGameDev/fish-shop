@extends('layouts.auth-shop')
@section('title','Đăng ký')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h3 class="fw-bold mb-1">Tạo tài khoản</h3>
    <div class="muted">Đăng ký để mua cá nhanh hơn ✨</div>
  </div>
  <a class="btn btn-outline-dark rounded-pill px-3" href="{{ route('login') }}">
    Đăng nhập
  </a>
</div>

<form method="POST" action="{{ route('register') }}">
  @csrf

  <div class="mb-3">
    <label class="form-label">Họ tên</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name') }}" required autofocus autocomplete="name">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}" required autocomplete="username">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Mật khẩu</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
           required autocomplete="new-password">
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-4">
    <label class="form-label">Nhập lại mật khẩu</label>
    <input type="password" name="password_confirmation" class="form-control"
           required autocomplete="new-password">
  </div>

  <button class="btn btn-brand text-white w-100 rounded-pill py-2 fw-semibold">
    <i class="bi bi-stars me-1"></i> Đăng ký
  </button>

  <div class="text-center mt-3 muted">
    Đã có tài khoản? <a href="{{ route('login') }}"><b>Đăng nhập</b></a>
  </div>
</form>
@endsection