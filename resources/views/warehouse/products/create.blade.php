@extends('layouts.warehouse')
@section('title', 'Thêm sản phẩm')

@section('content')
<div class="mb-4">
    <h1 class="fw-bold mb-1">Thêm sản phẩm</h1>
    <div class="text-muted">Sản phẩm tạo ở đây sẽ hiển thị ngoài cửa hàng</div>
</div>

<div class="warehouse-card">
    <form action="{{ route('warehouse.products.store') }}" method="POST">
        @csrf
        @include('warehouse.products._form')

        <button class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-save me-1"></i> Lưu sản phẩm
        </button>
    </form>
</div>
@endsection