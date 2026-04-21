@extends('layouts.shop')
@section('title', $product->name)

@section('content')
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

<div class="mt-5">
    <h4 class="fw-bold mb-4">Đánh giá sản phẩm</h4>

    <div class="row g-4">
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
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                @auth
                    @php
                        // Kiểm tra xem khách đã đánh giá chưa
                        $userReview = $product->reviews->where('user_id', auth()->id())->first();
                    @endphp

                    @if($userReview)
                        <div class="text-center py-4 h-100 d-flex flex-column justify-content-center">
                            <div class="text-warning mb-2 fs-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $userReview->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <h6 class="fw-bold">Bạn đã đánh giá sản phẩm này!</h6>
                            <p class="text-muted small mb-0">"{{ $userReview->comment }}"</p>
                        </div>
                    @else
                        <h6 class="fw-bold mb-3">Viết đánh giá của bạn</h6>
                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <span class="muted small">Chấm điểm:</span>
                                <div class="rating-stars">
                                    <input type="radio" name="rating" id="star5" value="5" checked><label for="star5" class="bi bi-star-fill text-warning fs-5 px-1"></label>
                                    <input type="radio" name="rating" id="star4" value="4"><label for="star4" class="bi bi-star-fill text-warning fs-5 px-1"></label>
                                    <input type="radio" name="rating" id="star3" value="3"><label for="star3" class="bi bi-star-fill text-warning fs-5 px-1"></label>
                                    <input type="radio" name="rating" id="star2" value="2"><label for="star2" class="bi bi-star-fill text-warning fs-5 px-1"></label>
                                    <input type="radio" name="rating" id="star1" value="1"><label for="star1" class="bi bi-star-fill text-warning fs-5 px-1"></label>
                                </div>
                                @error('rating') <span class="text-danger small ms-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <textarea name="comment" class="form-control rounded-4 bg-light border-0" rows="3" placeholder="Chia sẻ cảm nhận của bạn về độ tươi ngon của cá..." required></textarea>
                                @error('comment') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-dark rounded-pill px-4">Gửi đánh giá</button>
                        </form>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-chat-square-text text-muted fs-1 mb-2"></i>
                        <p class="mb-3">Vui lòng đăng nhập để chia sẻ cảm nhận của bạn về sản phẩm này.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-4">Đăng nhập ngay</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h5 class="fw-bold mb-4">Bình luận từ khách hàng</h5>
        
        @forelse($reviews as $review)
            <div class="d-flex gap-3 mb-4 pb-4 border-bottom">
                <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center fw-bold" style="width: 45px; height: 45px; flex-shrink: 0;">
                    {{ substr($review->user->name, 0, 1) }}
                </div>
                
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="fw-bold">{{ $review->user->name }}</div>
                        <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $review->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="text-warning small mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="mb-0 text-dark">{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4 bg-light rounded-4">
                Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!
            </div>
        @endforelse
    </div>
</div>

<style>
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-stars input {
        display: none;
    }
    .rating-stars label {
        cursor: pointer;
        color: #dee2e6 !important; 
        transition: 0.2s;
    }
    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffc107 !important; 
    }
</style>
<x-similar-products :product="$product" />
@endsection