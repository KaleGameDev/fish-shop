@extends('layouts.shop')
@section('title', $product->name)

@section('content')
<a href="{{ route('shop.index') }}" class="btn btn-link px-0 mb-3">
  <i class="bi bi-arrow-left"></i> Quay lại
</a>

<!-- Fancybox CSS CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css?v=16.1.2"/>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card-product position-relative">
      <!-- Main Image Lightbox -->
      <a data-fancybox="gallery" data-caption="{{ $product->name }} - {{ number_format($product->price) }}đ" href="{{ $product->image ?: 'https://picsum.photos/seed/fish'.$product->id.'/1200/900' }}">
        <img class="thumb img-zoom" style="height:420px" src="{{ $product->image ?: 'https://picsum.photos/seed/fish'.$product->id.'/1200/900' }}" alt="{{ $product->name }}">
        <div class="zoom-overlay">
          <i class="bi bi-zoom-in fs-3"></i>
          <span>Click để phóng to</span>
        </div>
      </a>
      
      <!-- Thumbnail Gallery (single for now, easy extend) -->
      <div class="gallery-thumbs mt-3">
        <a data-fancybox="gallery" href="{{ $product->image ?: 'https://picsum.photos/seed/fish'.$product->id.'/1200/900' }}" class="thumb-mini">
          <img src="{{ $product->image ?: 'https://picsum.photos/seed/fish'.$product->id.'/400/300' }}" alt="">
        </a>
        <!-- Add more thumbs if $product->gallery json exists -->
      </div>
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
                <i class="bi bi-bag-plus me-1"></i> Thêm vào giỏ
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

<!-- Rest unchanged: Reviews etc. -->
<div class="mt-5">
    <h4 class="fw-bold mb-4">Đánh giá sản phẩm</h4>
    <!-- ... existing reviews code ... -->
    <div class="row g-4">
        <!-- existing review stats -->
        <div class="col-md-4">
            <div class="card border-0 bg-light rounded-4 text-center p-4 h-100">
                <div class="display-3 fw-bold text-warning mb-2">
                    {{ number_format($averageRating ?: 0, 1) }}
                </div>
                <div class="text-warning mb-2 fs-4">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <i class="bi bi-star-fill"></i>
                        @else
                            <i class="bi bi-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="text-muted small">Dựa trên {{ $reviews->count() }} đánh giá</div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- existing review form -->
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                @auth
                    @php $userReview = $product->reviews->where('user_id', auth()->id())->first(); @endphp
                    @if($userReview)
                        <!-- existing user review display -->
                    @else
                        <!-- existing review form -->
                    @endif
                @else
                    <!-- login prompt -->
                @endauth
            </div>
        </div>
    </div>

    <!-- existing reviews list -->
    <div class="mt-5">
        <h5 class="fw-bold mb-4">Bình luận từ khách hàng</h5>
        @forelse($reviews as $review)
            <!-- existing review item -->
        @empty
            <!-- no reviews -->
        @endforelse
    </div>
</div>

<style>
    /* Existing styles + new */
    .rating-stars { /* existing */ }
    
    /* Zoom/Gallery new styles */
    .img-zoom {
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }
    .img-zoom:hover {
        transform: scale(1.05);
    }
    .zoom-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        pointer-events: none;
    }
    .card-product:hover .zoom-overlay {
        opacity: 1;
    }
    .gallery-thumbs {
        display: flex;
        gap: 8px;
    }
    .thumb-mini {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        transition: border-color 0.3s;
        flex-shrink: 0;
    }
    .thumb-mini img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumb-mini:hover {
        border-color: #0d6efd;
    }
</style>

<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js?v=16.1.2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Fancybox.bind('[data-fancybox]', {});
});
</script>

<x-similar-products :product="$product" />
@endsection

