@extends('layouts.shop')
@section('title', 'Thông tin tài khoản')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h1 class="section-title mb-1">Thông tin tài khoản</h1>
        <div class="muted">Xem thông tin cá nhân của bạn trên Fish Shop.</div>
    </div>

    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Về cửa hàng
    </a>
</div>

@if(session('status'))
    <div class="alert alert-success rounded-4">
        {{ session('status') }}
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="p-4 bg-white rounded-4 border h-100"
             style="border-color: rgba(15,23,42,.06) !important; box-shadow: 0 18px 45px rgba(2,6,23,.06);">
            <div class="text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                     style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#0d6efd,#14b8a6);color:white;font-size:2rem;font-weight:800;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <div class="muted">{{ $user->email }}</div>

                <div class="mt-3">
                    <span class="chip">
                        <i class="bi bi-person-check me-1"></i>
                        Thành viên Fish Shop
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="p-4 bg-white rounded-4 border"
             style="border-color: rgba(15,23,42,.06) !important; box-shadow: 0 18px 45px rgba(2,6,23,.06);">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1">Chi tiết tài khoản</h4>
                    <div class="muted">Thông tin đăng ký và liên hệ của bạn.</div>
                </div>

                <a href="{{ route('profile.edit') }}" class="btn btn-brand text-white rounded-pill">
                    <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa hồ sơ
                </a>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="feature">
                        <div class="muted small mb-1">Họ và tên</div>
                        <div class="fw-bold">{{ $user->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature">
                        <div class="muted small mb-1">Email</div>
                        <div class="fw-bold">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature">
                        <div class="muted small mb-1">Số điện thoại</div>
                        <div class="fw-bold">
                            {{ $user->phone ?: 'Chưa cập nhật' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature">
                        <div class="muted small mb-1">Trạng thái email</div>
                        <div class="fw-bold">
                            @if($user->email_verified_at)
                                Đã xác minh
                            @else
                                Chưa xác minh
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature">
                        <div class="muted small mb-1">Ngày tạo tài khoản</div>
                        <div class="fw-bold">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'Không có dữ liệu' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature">
                        <div class="muted small mb-1">Cập nhật gần nhất</div>
                        <div class="fw-bold">
                            {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'Không có dữ liệu' }}
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark rounded-pill">
                    <i class="bi bi-gear me-1"></i> Sửa thông tin
                </a>

                <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-shop me-1"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>
@endsection