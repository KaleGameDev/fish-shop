@extends('layouts.warehouse')
@section('title', 'Sửa sản phẩm')

@section('content')
<div class="mb-4">
    <h1 class="fw-bold mb-1">Sửa sản phẩm</h1>
    <div class="text-muted">Cập nhật thông tin hiển thị ngoài cửa hàng</div>
</div>

<div class="warehouse-card">
    <form action="{{ route('warehouse.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('warehouse.products._form', ['product' => $product])

        <button class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-save me-1"></i> Cập nhật sản phẩm
        </button>
    </form>
</div>
@endsection