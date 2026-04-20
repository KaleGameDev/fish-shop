@extends('layouts.shop')
@section('title', 'Giỏ hàng')

@section('content')
<style>
  .cart-page{
    --cart-border: rgba(15,23,42,.06);
    --cart-shadow: 0 18px 45px rgba(2,6,23,.06);
  }

  .cart-box{
    background: #fff;
    border: 1px solid var(--cart-border);
    border-radius: 22px;
    box-shadow: var(--cart-shadow);
  }

  .cart-item{
    background: #fff;
    border: 1px solid var(--cart-border);
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(2,6,23,.05);
    overflow: hidden;
  }

  .cart-item + .cart-item{
    margin-top: 1rem;
  }

  .cart-thumb-wrap{
    height: 100%;
    min-height: 220px;
    background: #eef2ff;
  }

  .cart-thumb{
    width: 100%;
    height: 100%;
    min-height: 220px;
    object-fit: cover;
    display: block;
  }

  .cart-item-body{
    padding: 1.25rem;
  }

  .cart-name{
    font-size: 1.15rem;
    font-weight: 800;
    line-height: 1.3;
    margin-bottom: .35rem;
    color: #0f172a;
  }

  .cart-desc{
    color: #64748b;
    font-size: .95rem;
    margin-bottom: .75rem;
  }

  .cart-meta{
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-bottom: 1rem;
  }

  .cart-price{
    font-weight: 800;
    background: rgba(20,184,166,.12);
    color: #0f766e;
    padding: .45rem .75rem;
    border-radius: 999px;
    border: 1px solid rgba(20,184,166,.20);
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
  }

  .cart-actions{
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
  }

  .cart-qty-form{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
  }

  .cart-qty-input{
    width: 90px;
    border-radius: 14px;
    padding: .55rem .75rem;
  }

  .cart-subtotal{
    text-align: right;
    min-width: 150px;
  }

  .cart-subtotal .label{
    color: #64748b;
    font-size: .85rem;
  }

  .cart-subtotal .value{
    font-size: 1.15rem;
    font-weight: 800;
    color: #0f172a;
  }

  .summary-card{
    position: sticky;
    top: 92px;
    padding: 1.25rem;
  }

  .summary-row{
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: .75rem;
  }

  .summary-row .label{
    color: #64748b;
  }

  .summary-total{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    font-size: 1.1rem;
    font-weight: 800;
    color: #0f172a;
  }

  .empty-cart{
    text-align: center;
    padding: 3rem 1.5rem;
  }

  .empty-cart .emoji{
    font-size: 3rem;
    margin-bottom: 1rem;
  }

  @media (max-width: 991.98px){
    .summary-card{
      position: static;
    }
  }

  @media (max-width: 767.98px){
    .cart-thumb-wrap,
    .cart-thumb{
      min-height: 220px;
      height: 220px;
    }

    .cart-item-body{
      padding: 1rem;
    }

    .cart-actions{
      align-items: stretch;
    }

    .cart-qty-form{
      width: 100%;
    }

    .cart-subtotal{
      width: 100%;
      text-align: left;
    }
  }
</style>

<div class="cart-page">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
      <h1 class="section-title mb-1">Giỏ hàng của bạn</h1>
      <div class="muted">Kiểm tra sản phẩm trước khi đặt hàng.</div>
    </div>

    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill">
      <i class="bi bi-arrow-left me-1"></i> Tiếp tục mua
    </a>
  </div>

  {{-- Thông báo --}}
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

  @php
    $subtotal = $cart->items->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    $shipping = $cart->items->count() ? 30000 : 0;
    $total = $subtotal + $shipping;
  @endphp

  @if($cart->items->count() > 0)
    <div class="row g-4">
      {{-- Danh sách sản phẩm --}}
      <div class="col-lg-8">
        @foreach($cart->items as $item)
          <div class="cart-item">
            <div class="row g-0">
              <div class="col-md-4">
                <div class="cart-thumb-wrap">
                  <img
                    src="{{ $item->product->image ?: 'https://picsum.photos/seed/fish'.$item->product->id.'/900/600' }}"
                    alt="{{ $item->product->name }}"
                    class="cart-thumb"
                  >
                </div>
              </div>

              <div class="col-md-8">
                <div class="cart-item-body">
                  <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                      <div class="cart-name">{{ $item->product->name }}</div>
                      <div class="cart-desc">
                        {{ $item->product->description ?: 'Sản phẩm tươi ngon, phù hợp cho bữa ăn gia đình.' }}
                      </div>
                    </div>

                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-outline-danger rounded-pill border-0">
                        <i class="bi bi-trash me-1"></i> Xóa
                      </button>
                    </form>
                  </div>

                  <div class="cart-meta">
                    <span class="chip">
                      <i class="bi bi-box-seam me-1"></i>
                      Tồn kho: {{ $item->product->stock }}
                    </span>
                    <span class="chip">
                      <i class="bi bi-snow2 me-1"></i>
                      Bảo quản lạnh
                    </span>
                  </div>

                  <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="cart-price">{{ number_format($item->price) }}đ</span>
                  </div>

                  <div class="cart-actions">
                    <form action="{{ route('cart.update', $item) }}" method="POST" class="cart-qty-form">
                      @csrf
                      @method('PATCH')

                      <label class="muted small mb-0">Số lượng</label>

                      <input
                        type="number"
                        name="quantity"
                        min="1"
                        max="{{ $item->product->stock }}"
                        value="{{ $item->quantity }}"
                        class="form-control cart-qty-input"
                      >

                      <button class="btn btn-outline-dark rounded-pill">
                        <i class="bi bi-arrow-repeat me-1"></i>
                      </button>
                    </form>

                    <div class="cart-subtotal">
                      <div class="label">Thành tiền</div>
                      <div class="value">{{ number_format($item->price * $item->quantity) }}đ</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Tóm tắt & Thanh toán --}}
      <div class="col-lg-4">
        <div class="cart-box summary-card">
          <h4 class="fw-bold mb-3">Tóm tắt đơn hàng</h4>

          <div class="summary-row">
            <span class="label">Số món</span>
            <span>{{ $cart->items->sum('quantity') }}</span>
          </div>

          <div class="summary-row">
            <span class="label">Tạm tính</span>
            <span>{{ number_format($subtotal) }}đ</span>
          </div>

          <div class="summary-row">
            <span class="label">Phí giao hàng</span>
            <span>{{ number_format($shipping) }}đ</span>
          </div>

          <hr>

          <div class="summary-total mb-4">
            <span>Tổng cộng</span>
            <span class="text-brand">{{ number_format($total) }}đ</span>
          </div>

          {{-- Form Thanh Toán Thực Tế --}}
          <form action="{{ route('cart.checkout') }}" method="POST" class="mb-3">
            @csrf

            <div class="mb-3">
              <label class="form-label small fw-bold text-dark">Phương thức thanh toán</label>
              <select name="payment_method" class="form-select rounded-pill px-3">
                  <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                  <option value="vnpay">Thanh toán qua VNPAY</option>
              </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Số điện thoại nhận hàng</label>
                <input type="text" name="phone" class="form-control rounded-pill px-3" 
                       value="{{ auth()->user()->phone }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Địa chỉ giao cá tận nơi</label>
                <textarea name="address" class="form-control rounded-4 px-3" rows="2" 
                          placeholder="Số nhà, tên đường, phường/xã..." required></textarea>
            </div>

            <button type="submit" class="btn btn-brand text-white rounded-pill w-100 py-3 fw-bold shadow-sm">
                <i class="bi bi-shield-check me-2"></i> XÁC NHẬN THANH TOÁN
            </button>
          </form>

          <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-link text-danger w-100 text-decoration-none small">
              <i class="bi bi-x-circle me-1"></i> Xóa toàn bộ giỏ hàng
            </button>
          </form>
        </div>
      </div>
    </div>
  @else
    <div class="cart-box empty-cart">
      <div class="emoji">🛒</div>
      <h3 class="fw-bold mb-2">Giỏ hàng đang trống</h3>
      <p class="muted mb-4">Hãy chọn vài món cá tươi ngon cho hôm nay.</p>
      <a href="{{ route('shop.index') }}" class="btn btn-brand text-white rounded-pill px-5 py-2">
        <i class="bi bi-bag me-1"></i> Mua sắm ngay
      </a>
    </div>
  @endif
</div>
@endsection