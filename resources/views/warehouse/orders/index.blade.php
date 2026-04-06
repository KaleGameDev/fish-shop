@extends('layouts.warehouse') {{-- Chú ý: Nếu khu vực kho bạn dùng layout khác thì sửa lại tên layout nhé --}}
@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📦 Quản lý Đơn hàng (Kho)</h2>
        <a href="{{ route('warehouse.products.index') }}" class="btn btn-outline-dark rounded-pill">
            <i class="bi bi-box-seam me-1"></i> Quản lý Sản phẩm
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">Mã đơn</th>
                        <th class="py-3">Khách hàng / Liên hệ</th>
                        <th class="py-3">Chi tiết món cá</th>
                        <th class="py-3">Tổng tiền</th>
                        <th class="py-3">Trạng thái</th>
                        <th class="py-3 text-end px-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 fw-bold text-brand">#{{ $order->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $order->user->name }}</div>
                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $order->shipping_phone }}</div>
                                <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $order->shipping_address }}</div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($order->items as $item)
                                        <li>- {{ $item->product->name }} (x{{ $item->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="fw-bold">{{ number_format($order->total) }}đ</td>
                            <td>
                                @php
                                    $badges = [
                                        'pending' => 'bg-warning text-dark',
                                        'shipping' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger'
                                    ];
                                @endphp
                                <span class="badge rounded-pill {{ $badges[$order->status] }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                           <td class="text-end px-4">
    <div class="d-flex justify-content-end align-items-center gap-2">
        <form action="{{ route('warehouse.orders.update_status', $order) }}" method="POST" class="d-flex gap-2">
            @csrf
            @method('PATCH')
            <select name="status" class="form-select form-select-sm rounded-pill" style="width: auto;">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
            </select>
            <button type="submit" class="btn btn-sm btn-dark rounded-pill">Lưu</button>
        </form>

        <form action="{{ route('warehouse.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đơn hàng này không? Dữ liệu không thể khôi phục!');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Xóa đơn hàng">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Kho chưa nhận được đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection