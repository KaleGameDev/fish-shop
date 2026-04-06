@extends('layouts.shop')
@section('title', 'Đăng ký - Fish Shop')

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
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1">Tạo tài khoản</h3>
                <div class="text-muted small">Đăng ký để mua cá nhanh hơn ✨</div>
            </div>
            <a class="btn btn-outline-dark rounded-pill btn-sm px-3" href="{{ route('login') }}">
                Đăng nhập
            </a>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small">Họ tên</label>
                <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Ví dụ: Nguyễn Văn A">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autocomplete="username" placeholder="Nhập email của bạn">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Mật khẩu</label>
                <input type="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror"
                       required autocomplete="new-password" placeholder="••••••••">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control form-control-custom"
                       required autocomplete="new-password" placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-login mb-3 shadow-sm">
                <i class="bi bi-stars me-1"></i> Đăng ký ngay
            </button>

            <div class="text-center small text-muted">
                Đã có tài khoản? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: var(--brand);">Đăng nhập</a>
            </div>
        </form>
    </div>
</div>
@endsection