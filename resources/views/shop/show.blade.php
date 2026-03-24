@extends('layouts.shop')
@section('title', $product->name)

@section('content')
@if(session('success'))
    <div class="alert alert-success rounded-4">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
@endif
<a href="{{ route('shop.index') }}" class="btn btn-link px-0 mb-3">
  <i class="bi bi-arrow-left"></i> Quay lại
</a>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card-product">
      <img class="thumb" style="height:420px" src="{{ $product->image ?: 'https://picsum.photos/seed/fish'.$product->id.'/1200/900' }}" alt="">
    </div>
  </div>

  <div class="col-lg-6">
    <div class="p-4 bg-white rounded-4 border" style="border-color: rgba(15,23,42,.06) !important; box-shadow: 0 18px 45px rgba(2,6,23,.06);">
      <div class="chip mb-2"><i class="bi bi-patch-check me-1"></i> Fresh guarantee</div>
      <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="price">{{ number_format($product->price) }}đ</div>
        <div class="muted">• Tồn kho: {{ $product->stock }}</div>
      </div>

      <p class="muted mb-4">{{ $product->description }}</p>

      <div class="d-flex gap-2">
        @if(auth()->check())
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button class="btn btn-brand text-white rounded-pill px-4 py-2">
                    <i class="bi bi-bag-plus me-1"></i> Thêm vào giỏ
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-brand text-white rounded-pill px-4 py-2">
                <i class="bi bi-person me-1"></i> Đăng nhập để mua
            </a>
        @endif
        <button class="btn btn-outline-dark rounded-pill px-4 py-2" disabled>
          <i class="bi bi-lightning me-1"></i> Mua ngay
        </button>
      </div>

      <div class="row g-2 mt-4">
        <div class="col-6"><div class="feature"><i class="bi bi-truck me-1"></i> Giao nhanh</div></div>
        <div class="col-6"><div class="feature"><i class="bi bi-shield-check me-1"></i> Đổi trả 24h</div></div>
      </div>
    </div>
  </div>
</div>
@endsection