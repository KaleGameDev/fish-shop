@extends('layouts.shop')
@section('title', 'Cài đặt tài khoản')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px; z-index: 10;">
                <div class="card-body p-3">
                    <div class="text-center mb-4 mt-3">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm"
                             style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#0d6efd,#14b8a6);color:white;font-size:1.5rem;font-weight:800;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold mb-0 text-truncate">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                    
                    <div class="nav flex-column nav-pills gap-2">
                        <a href="#info" class="nav-link active rounded-3 small fw-bold py-2">
                            <i class="bi bi-person-circle me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="#security" class="nav-link rounded-3 small fw-bold py-2 text-dark border border-light">
                            <i class="bi bi-shield-lock me-2"></i> Bảo mật & Mật khẩu
                        </a>
                        <a href="#danger" class="nav-link rounded-3 small fw-bold py-2 text-danger border border-danger-subtle">
                            <i class="bi bi-exclamation-triangle me-2"></i> Khu vực nguy hiểm
                        </a>
                    </div>

                    <hr class="my-4 opacity-50">
                    <a href="{{ route('profile.show') }}" class="btn btn-light w-100 rounded-pill btn-sm fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Xem hồ sơ
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div id="info" class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">Thông tin cá nhân</h5>
                    <p class="text-muted small mb-0">Quản lý tên hiển thị và địa chỉ liên lạc của bạn.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Họ và tên</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control bg-light border-0 shadow-none py-2" value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-0 shadow-none py-2" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mt-4 d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-brand text-white rounded-pill px-4 fw-bold">Lưu thay đổi</button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success small"><i class="bi bi-check2-all me-1"></i>Đã cập nhật!</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div id="security" class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">Đổi mật khẩu</h5>
                    <p class="text-muted small mb-0">Nên sử dụng mật khẩu dài để tăng tính bảo mật.</p>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" class="form-control bg-light border-0 shadow-none py-2" placeholder="••••••••">
                                @error('current_password') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Mật khẩu mới</label>
                                <input type="password" name="password" class="form-control bg-light border-0 shadow-none py-2">
                                @error('password') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0 shadow-none py-2">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold mt-4">Cập nhật mật khẩu</button>
                    </form>
                </div>
            </div>

            <div id="danger" class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden border-start border-danger border-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-danger mb-1">Xóa tài khoản</h5>
                        <p class="text-muted small mb-0">Hành động này sẽ xóa vĩnh viễn dữ liệu của bạn.</p>
                    </div>
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#delModal">
                        Xóa ngay
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 p-3 shadow-lg">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body text-center">
                    <div class="text-danger mb-3"><i class="bi bi-exclamation-octagon-fill display-4"></i></div>
                    <h5 class="fw-bold">Bạn chắc chắn muốn xóa?</h5>
                    <p class="text-muted small">Vui lòng nhập mật khẩu để xác nhận rằng bạn muốn xóa vĩnh viễn tài khoản của mình.</p>
                    <input type="password" name="password" class="form-control rounded-3 py-2 mt-3" placeholder="Nhập mật khẩu xác nhận">
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Xóa vĩnh viễn</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Hiệu ứng smooth scroll */
    html { scroll-behavior: smooth; }
    
    /* Tối ưu UI cho Sidebar */
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #0d6efd, #14b8a6) !important;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
    }
    .x-small { font-size: 0.75rem; }
    
    /* Ẩn hiện mượt cho thông báo status */
    .anim-fade {
        animation: fadeInOut 3s forwards;
    }
    @keyframes fadeInOut {
        0% { opacity: 0; }
        20% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
@endsection