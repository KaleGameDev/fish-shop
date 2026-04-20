@extends('layouts.warehouse')
@section('title', 'Thống kê tổng quan')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">📊 Tổng quan hệ thống</h2>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Doanh thu tổng</h6>
                    <h2 class="fw-bold mb-0">{{ number_format($totalRevenue) }}đ</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Đơn chờ xử lý</h6>
                    <h2 class="fw-bold mb-0">{{ $pendingOrders }} <span class="fs-6 fw-normal">đơn</span></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Khách hàng</h6>
                    <h2 class="fw-bold mb-0">{{ $totalCustomers }} <span class="fs-6 fw-normal">người</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">📈 Biến động doanh thu (7 ngày qua)</h5>
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">📦 Tỷ lệ đơn hàng</h5>
                    <canvas id="orderChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold text-danger mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Cảnh báo sắp hết hàng</h5>
        </div>
        <div class="card-body p-4">
            @if($lowStockProducts->isEmpty())
                <div class="text-success fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Kho hàng đang rất dồi dào, không có sản phẩm nào thiếu hụt.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Tồn kho</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $product->image ?: 'https://picsum.photos/seed/'.$product->id.'/100' }}" class="rounded-3 me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <span class="fw-bold">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($product->price) }}đ</td>
                                    <td>
                                        <span class="badge bg-danger rounded-pill px-3 py-2">Chỉ còn {{ $product->stock }} con</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('warehouse.products.edit', $product) }}" class="btn btn-sm btn-outline-dark rounded-pill">Nhập thêm</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Cấu hình Biểu đồ Doanh thu (Line Chart)
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartDates) !!}, // Lấy mảng ngày từ PHP
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: {!! json_encode($chartRevenues) !!}, // Lấy mảng tiền từ PHP
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#10b981',
                    fill: true,
                    tension: 0.4 // Làm cong đường vẽ
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // 2. Cấu hình Biểu đồ Trạng thái đơn (Doughnut Chart)
        const ctxOrder = document.getElementById('orderChart').getContext('2d');
        new Chart(ctxOrder, {
            type: 'doughnut',
            data: {
                labels: ['Chờ xử lý', 'Đang giao', 'Hoàn thành', 'Đã hủy'],
                datasets: [{
                    data: {!! json_encode($chartOrderStatuses) !!},
                    backgroundColor: [
                        '#f59e0b', // Vàng (Pending)
                        '#3b82f6', // Xanh dương (Shipping)
                        '#10b981', // Xanh lá (Completed)
                        '#ef4444'  // Đỏ (Cancelled)
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                cutout: '70%', // Độ rỗng của vòng tròn
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endsection




