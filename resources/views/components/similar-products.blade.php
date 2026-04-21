<div class="mt-5 border-top pt-5">
    <h4 class="fw-bold mb-4">Sản phẩm tương tự có thể bạn thích</h4>
    <div class="row g-4">
        @forelse($similarProducts as $item)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <img src="{{ $item->image ?: 'https://picsum.photos/seed/fish'.$item->id.'/400/300' }}" 
                         class="card-img-top rounded-top-4" 
                         alt="{{ $item->name }}" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center d-flex flex-column">
                        <h6 class="card-title fw-bold text-truncate" title="{{ $item->name }}">{{ $item->name }}</h6>
                        <p class="text-danger fw-bold mb-3">{{ number_format($item->price) }}đ</p>
                        
                        <div class="mt-auto">
                            <a href="{{ route('shop.show', $item) }}" class="btn btn-sm btn-outline-dark rounded-pill px-4">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center py-3 bg-light rounded-4">Chưa có sản phẩm tương tự.</p>
            </div>
        @endforelse
    </div>
</div>