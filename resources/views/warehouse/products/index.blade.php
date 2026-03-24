@extends('layouts.warehouse')
@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h1 class="fw-bold mb-1">Danh sách sản phẩm</h1>
        <div class="text-muted">Quản lý dữ liệu hiển thị ngoài cửa hàng</div>
    </div>

    <a href="{{ route('warehouse.products.create') }}" class="btn btn-primary rounded-pill">
        <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm
    </a>
</div>

<div class="warehouse-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Ảnh</th>
                    <th width="180">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $product->name }}</div>
                            <div class="text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</div>
                        </td>
                        <td>{{ number_format($product->price) }}đ</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width:70px;height:50px;object-fit:cover;border-radius:10px;">
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('warehouse.products.edit', $product) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                    Sửa
                                </a>

                                <form action="{{ route('warehouse.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Chưa có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection