@extends('layouts.shop')
@section('title', 'Đăng nhập kho')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="p-4 bg-white rounded-4 border" style="border-color: rgba(15,23,42,.06) !important; box-shadow: 0 18px 45px rgba(2,6,23,.06);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="brand-badge">📦</div>
                <div>
                    <h2 class="mb-0 fw-bold">Đăng nhập kho</h2>
                    <div class="muted">Nhập mật khẩu để vào khu quản lý sản phẩm</div>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('warehouse.login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu kho</label>
                    <input type="password" name="password" class="form-control rounded-4" placeholder="Nhập mật khẩu">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-brand text-white rounded-pill px-4" type="submit">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Vào kho
                </button>
            </form>
        </div>
    </div>
</div>
@endsection