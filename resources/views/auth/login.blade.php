@extends('layouts.shop')
@section('title', 'Đăng nhập - Fish Shop')

@section('content')
<style>
    .login-wrapper {
        max-width: 900px;
        margin: 2rem auto;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        min-height: 500px;
    }
    .login-left {
        width: 45%;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #fff;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .login-right {
        width: 55%;
        padding: 3rem;
    }
    .badge-custom {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        font-size: 0.85rem;
        margin-bottom: 12px;
        width: fit-content;
    }
    .form-control-custom {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
    }
    .form-control-custom:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13,110,253,0.1);
    }
    .btn-login {
        background: linear-gradient(135deg, #0d6efd, #14b8a6);
        border: none;
        border-radius: 12px;
        padding: 0.75rem;
        font-weight: 600;
        color: #fff;
        width: 100%;
        transition: all 0.2s;
    }
    .btn-login:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
        color: #fff;
    }
    @media (max-width: 768px) {
        .login-wrapper { flex-direction: column; }
        .login-left, .login-right { width: 100%; padding: 2rem; }
    }
</style>

<div class="login-wrapper">
    <div class="login-left">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="brand-badge" style="width: 32px; height: 32px; font-size: 14px; box-shadow: none;">🐟</div>
                <h3 class="fw-bold mb-0">Fish Shop</h3>
            </div>
            <p class="text-white-50 mb-4">Cá tươi mỗi ngày</p>

            <div class="d-flex flex-column">
                <div class="badge-custom"><i class="bi bi-truck me-2"></i> Giao nhanh 30-60p</div>
                <div class="badge-custom"><i class="bi bi-shield-check me-2"></i> Đảm bảo tươi</div>
                <div class="badge-custom"><i class="bi bi-arrow-repeat me-2"></i> Đổi trả 24h</div>
            </div>
        </div>

        <a href="{{ route('shop.index') }}" class="text-white-50 text-decoration-none mt-4">
            <i class="bi bi-arrow-left me-1"></i> Quay lại cửa hàng
        </a>
    </div>

    <div class="login-right">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h3 class="fw-bold mb-1">Đăng nhập</h3>
                <p class="text-muted small">Chào mừng bạn quay lại </p>
            </div>
            <a href="{{ route('register') }}" class="btn btn-outline-dark rounded-pill btn-sm px-3">Đăng ký</a>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-custom" value="{{ old('email') }}" placeholder="Nhập email của bạn" required autofocus>
                @error('email')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control form-control-custom" placeholder="••••••••" required>
                @error('password')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted small" for="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none">Quên mật khẩu?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-login mb-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
            </button>

            <div class="text-center small text-muted">
                Chưa có tài khoản? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--brand);">Đăng ký</a>
            </div>
        </form>
    </div>
</div>
@endsection