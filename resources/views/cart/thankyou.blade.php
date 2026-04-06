@extends('layouts.shop')
@section('title', 'Thanh toán thành công')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <div class="mb-4">
                    <div class="display-1 text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                
                <h1 class="fw-bold mb-3">Đặt hàng thành công!</h1>
                <p class="text-muted mb-4">
                    Cảm ơn Phúc đã tin tưởng Fish Shop. Đơn hàng <strong>#{{ $order->id }}</strong> của bạn đang được xử lý.
                </p>

                <div class="bg-light rounded-4 p-4 mb-4 text-start">
                    <h6 class="fw-bold mb-3"><i class="bi bi-receipt me-2"></i>Tóm tắt đơn hàng</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach($order->items as $item)
                        <li class="d-flex justify-content-between mb-2">
                            <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                            <span>{{ number_format($item->price * $item->quantity) }}đ</span>
                        </li>
                        @endforeach
                        <hr>
                        <li class="d-flex justify-content-between fw-bold">
                            <span>Tổng cộng (đã bao gồm phí ship)</span>
                            <span class="text-brand">{{ number_format($order->total) }}đ</span>
                        </li>
                    </ul>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-dark w-100 rounded-pill py-2">
                            <i class="bi bi-house me-1"></i> Về trang chủ
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <button onclick="window.print()" class="btn btn-brand text-white w-100 rounded-pill py-2">
                            <i class="bi bi-printer me-1"></i> In hóa đơn
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection