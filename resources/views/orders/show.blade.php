@extends('layouts.shop')
@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<style>
    .tracking-wrap {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        margin-bottom: 2rem;
    }
    .step {
        text-align: center;
        position: relative;
        flex: 1;
    }
    .step::after {
        content: '';
        position: absolute;
        top: 25px;
        left: 50%;
        width: 100%;
        height: 3px;
        background: #e2e8f0; /* Đường kẻ xám mặc định */
        z-index: 1;
    }
    .step:last-child::after {
        display: none;
    }
    /* Chỉ tô xanh đường kẻ nếu có class line-active */
    .step.line-active::after {
        background: #14b8a6; 
    }
    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f1f5f9; /* Nền xám nhạt cho icon chưa tới */
        color: #94a3b8; /* Đổi màu icon đậm hơn để dễ nhìn */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        position: relative;
        z-index: 2;
        margin-bottom: 0.5rem;
        border: 3px solid #fff;
        transition: all 0.3s ease;
    }
    .step.active .step-icon {
        background: #14b8a6; /* Màu xanh khi active */
        color: #fff;
        box-shadow: 0 0 0 5px rgba(20, 184, 166, 0.15); /* Hiệu ứng viền sáng tỏa ra bên ngoài */
    }
    .step-text {
        font-weight: 600;
        font-size: 0.9rem;
        color: #94a3b8;
    }
    .step.active .step-text {
        color: #0f172a; /* Chữ đậm màu đen khi active */
    }
</style>
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('orders.history') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Quay lại lịch sử
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0">Chi tiết đơn hàng #{{ $order->id }}</h2>
        <span class="text-muted">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="fw-bold mb-1">Trạng thái đơn hàng: 
                    <span class="text-brand">{{ strtoupper($order->status) }}</span>
                </h5>
                <p class="text-muted mb-0 small">Mọi thay đổi sau khi giao hàng vui lòng gọi Hotline.</p>
            </div>

            @if($order->status == 'pending')
                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-x-lg me-1"></i> Hủy đơn hàng ngay
                    </button>
                </form>
            @elseif($order->status == 'shipping')
                <a href="tel:0123456789" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-telephone-fill me-1"></i> Gọi hỗ trợ hủy đơn
                </a>
            @endif
        </div>
    </div>

 @if($order->status != 'cancelled')
        <div class="tracking-wrap d-flex justify-content-between">
            <div class="step active {{ in_array($order->status, ['shipping', 'completed']) ? 'line-active' : '' }}">
                <div class="step-icon"><i class="bi bi-clipboard-check"></i></div>
                <div class="step-text">Đã tiếp nhận</div>
            </div>
            
            <div class="step {{ in_array($order->status, ['shipping', 'completed']) ? 'active' : '' }} {{ $order->status == 'completed' ? 'line-active' : '' }}">
                <div class="step-icon"><i class="bi bi-truck"></i></div>
                <div class="step-text">Đang giao hàng</div>
            </div>
            
            <div class="step {{ $order->status == 'completed' ? 'active' : '' }}">
                <div class="step-icon"><i class="bi bi-house-door"></i></div>
                <div class="step-text">Đã giao thành công</div>
            </div>
        </div>
    @else
        <div class="alert alert-danger rounded-4 py-3 mb-4 text-center fw-bold">
            <i class="bi bi-x-circle-fill me-2"></i> Đơn hàng này đã bị hủy.
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-3 mb-3">Thông tin nhận hàng</h5>
                    <p class="mb-2"><strong>Người nhận:</strong> {{ $order->user->name }}</p>
                    <p class="mb-2"><strong>Điện thoại:</strong> {{ $order->shipping_phone }}</p>
                    <p class="mb-2"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p class="mb-0"><strong>Phương thức:</strong> Thanh toán khi nhận hàng (COD)</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-3 mb-3">Sản phẩm đã đặt</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-bottom">
                                        <td style="width: 80px;">
                                            <img src="{{ $item->product->image ?: 'https://picsum.photos/seed/'.$item->product->id.'/100' }}" 
                                                 class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <div class="text-muted small">Giá: {{ number_format($item->price) }}đ</div>
                                        </td>
                                        <td class="text-center">x{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">{{ number_format($item->price * $item->quantity) }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <div style="width: 250px;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính:</span>
                                <span>{{ number_format($order->total - 30000) }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Phí giao hàng:</span>
                                <span>30,000đ</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Tổng cộng:</span>
                                <span class="h5 mb-0 fw-bold text-brand">{{ number_format($order->total) }}đ</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection