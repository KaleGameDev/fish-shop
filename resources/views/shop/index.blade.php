@extends('layouts.shop')
@section('title','Cửa hàng')

@section('content')
<div class="hero p-4 p-md-5 mb-4">
  <div class="row align-items-center g-4 position-relative">
    <div class="col-lg-7">
      <div class="chip mb-2"><i class="bi bi-lightning-charge-fill me-1"></i> Fresh • Clean • Fast</div>
      <h1 class="display-5 fw-bold mb-2" style="letter-spacing:-.03em;">
        Cá tươi mỗi ngày, chuẩn vị biển
      </h1>
      <p class="muted mb-4" style="max-width: 55ch;">
        Chọn cá theo nhu cầu, xem chi tiết, đặt hàng nhanh. Giao tận nơi – đóng gói sạch – bảo quản chuẩn.
      </p>

      <div class="d-flex flex-wrap gap-2">
        <a href="#list" class="btn btn-brand text-white rounded-pill px-4 py-2">
          <i class="bi bi-bag-check me-1"></i> Xem sản phẩm
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2">
          <i class="bi bi-gear me-1"></i> Quản lý Users
        </a>
      </div>

      <div class="d-flex gap-3 mt-4 muted">
        <div><i class="bi bi-truck me-1"></i> Giao nhanh</div>
        <div><i class="bi bi-shield-check me-1"></i> Đảm bảo tươi</div>
        <div><i class="bi bi-arrow-repeat me-1"></i> Đổi trả 24h</div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="p-4 bg-white rounded-4 border" style="border-color: rgba(15,23,42,.06) !important; box-shadow: 0 18px 45px rgba(2,6,23,.08);">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="fw-bold">Hôm nay có</div>
          <span class="price">{{ $products->total() }} sản phẩm</span>
        </div>

        <div class="row g-3">
          <div class="col-6">
            <div class="feature p-3">
              <div class="fw-bold"><i class="bi bi-droplet-half me-1"></i> Cá sạch</div>
              <div class="muted small">Nguồn rõ ràng</div>
            </div>
          </div>
          <div class="col-6">
            <div class="feature p-3">
              <div class="fw-bold"><i class="bi bi-thermometer-snow me-1"></i> Bảo quản</div>
              <div class="muted small">Chuẩn lạnh</div>
            </div>
          </div>
          <div class="col-12">
            <div class="feature p-3 d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-bold"><i class="bi bi-star-fill text-warning me-1"></i> Shop rating</div>
                <div class="muted small">4.9/5 (demo)</div>
              </div>
              <span class="chip">Best seller</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div id="list" class="d-flex justify-content-between align-items-end mb-3">
  <div>
    <h2 class="section-title mb-1">Danh sách cá</h2>
    <div class="muted">Chọn sản phẩm bạn thích và xem chi tiết.</div>
  </div>

  @if(request('q'))
    <a class="btn btn-outline-secondary rounded-pill" href="{{ route('shop.index') }}">
      <i class="bi bi-x-lg me-1"></i> Xóa lọc
    </a>
  @endif
</div>

<div class="row g-3">
@forelse($products as $p)
  <div class="col-12 col-sm-6 col-lg-4">
    <div class="card-product">
      <img class="thumb" src="{{ $p->image ?: 'https://picsum.photos/seed/fish'.$p->id.'/900/600' }}" alt="">
      <div class="p-3">
        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
          <div>
            <div class="fw-bold fs-5">{{ $p->name }}</div>
            <div class="muted small">Tồn kho: {{ $p->stock }}</div>
          </div>
          <div class="price">{{ number_format($p->price) }}đ</div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="chip"><i class="bi bi-clock me-1"></i> 30–60p</span>
          <span class="chip"><i class="bi bi-snow2 me-1"></i> Lạnh</span>
          <span class="chip"><i class="bi bi-patch-check me-1"></i> Fresh</span>
        </div>

        <div class="d-flex gap-2">
          <a class="btn btn-outline-dark rounded-pill w-100" href="{{ route('shop.show', $p) }}">
            <i class="bi bi-eye me-1"></i> Chi tiết
          </a>
          <button class="btn btn-brand text-white rounded-pill w-100" disabled>
            <i class="bi bi-bag-plus me-1"></i> Thêm giỏ
          </button>
        </div>
      </div>
    </div>
  </div>
@empty
  <div class="col-12">
    <div class="alert alert-warning rounded-4">Không tìm thấy sản phẩm phù hợp.</div>
  </div>
@endforelse
</div>

<div class="mt-4">
  {{ $products->appends(request()->query())->links() }}
</div>
@endsection

<style>
    .auth-btn{
        white-space: nowrap;
        border-radius: 999px !important;
        padding: .55rem 1rem !important;
        line-height: 1 !important;
    }
    .auth-wrap{
        display:flex;
        gap:.5rem;
        align-items:center;
        flex-wrap: nowrap;
    }

    .nav-actions{
        flex: 0 0 auto;
    }
</style>