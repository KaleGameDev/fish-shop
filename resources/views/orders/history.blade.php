@extends('layouts.shop')
@section('title', 'Lịch sử mua hàng')

@section('content')
<div class="container py-4">
    <h1 class="section-title mb-4">Lịch sử mua hàng của bạn</h1>

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

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <div class="display-1 mb-3">📦</div>
            <h4>Bạn chưa có đơn hàng nào.</h4>
            <a href="{{ route('shop.index') }}" class="btn btn-brand text-white rounded-pill px-4 mt-3">Mua sắm ngay</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center p-3">
                    <div>
                        <span class="fw-bold">Mã đơn: #{{ $order->id }}</span>
                        <span class="text-muted ms-3 small">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <span class="badge rounded-pill 
                        {{ $order->status == 'pending' ? 'bg-warning text-dark' : ($order->status == 'completed' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-secondary')) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $item->product->image ?: 'https://picsum.photos/seed/'.$item->product->id.'/100' }}" 
                                 class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $item->product->name }}</div>
                                <div class="text-muted small">Số lượng: {{ $item->quantity }} x {{ number_format($item->price) }}đ</div>
                            </div>
                            <div class="fw-bold">{{ number_format($item->price * $item->quantity) }}đ</div>
                        </div>
                    @endforeach
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-3">
                        <div>
                            <div class="small text-muted mb-1">Giao đến: {{ $order->shipping_address }}</div>
                            <div class="h5 mb-0 fw-bold text-brand">Tổng tiền: {{ number_format($order->total) }}đ</div>
                        </div>
                        
                        <div class="d-flex gap-2 align-items-center">
                            @if($order->status == 'pending')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hủy đơn</button>
                                </form>
                            @elseif($order->status == 'shipping')
                                <span class="badge bg-light text-muted border rounded-pill py-2">
                                    <i class="bi bi-info-circle me-1"></i> Đang giao - Liên hệ để hủy
                                </span>
                            @endif

                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-dark rounded-pill px-3">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection