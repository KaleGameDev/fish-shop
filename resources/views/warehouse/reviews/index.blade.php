@extends('layouts.warehouse')
@section('title', 'Quản lý Đánh giá')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Quản lý Đánh giá khách hàng</h3>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Đánh giá</th>
                        <th>Nội dung bình luận</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr class="{{ $review->is_hidden ? 'bg-light text-muted' : '' }}">
                            <td class="ps-4 fw-bold">{{ $review->user->name }}</td>
                            <td>
                                <a href="{{ route('shop.show', $review->product) }}" class="text-decoration-none" target="_blank">
                                    {{ Str::limit($review->product->name, 30) }}
                                </a>
                            </td>
                            <td>
                                <div class="text-warning small">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 200px;" title="{{ $review->comment }}">
                                    "{{ $review->comment }}"
                                </span>
                            </td>
                            <td>
                                @if($review->is_hidden)
                                    <span class="badge bg-secondary rounded-pill">Đã ẩn</span>
                                @else
                                    <span class="badge bg-success rounded-pill">Đang hiện</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm {{ $review->is_hidden ? 'btn-success' : 'btn-outline-warning' }} rounded-pill px-3 me-1">
                                        @if($review->is_hidden)
                                            <i class="bi bi-eye"></i> Hiện
                                        @else
                                            <i class="bi bi-eye-slash"></i> Ẩn
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa vĩnh viễn bình luận này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Chưa có đánh giá nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $reviews->links() }}
</div>
@endsection