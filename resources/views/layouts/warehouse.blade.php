<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản lý kho')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body{
            background:#f6f7fb;
            color:#0f172a;
        }
        .warehouse-shell{
            min-height:100vh;
        }
        .warehouse-sidebar{
            width:260px;
            background: linear-gradient(180deg, #0f172a, #111827);
            color:#fff;
            min-height:100vh;
            padding:24px 18px;
            position:fixed;
            top:0;
            left:0;
        }
        .warehouse-main{
            margin-left:260px;
            padding:24px;
        }
        .warehouse-brand{
            font-size:1.2rem;
            font-weight:800;
            margin-bottom:1.5rem;
        }
        .warehouse-link{
            display:flex;
            align-items:center;
            gap:.65rem;
            color:#cbd5e1;
            text-decoration:none;
            padding:.8rem 1rem;
            border-radius:14px;
            margin-bottom:.5rem;
        }
        .warehouse-link:hover,
        .warehouse-link.active{
            background: rgba(255,255,255,.08);
            color:#fff;
        }
        .warehouse-card{
            background:#fff;
            border:1px solid rgba(15,23,42,.06);
            border-radius:22px;
            box-shadow:0 18px 45px rgba(2,6,23,.06);
            padding:1.25rem;
        }
        @media (max-width: 991.98px){
            .warehouse-sidebar{
                position:static;
                width:100%;
                min-height:auto;
            }
            .warehouse-main{
                margin-left:0;
            }
        }
    </style>
</head>
<body>
<div class="warehouse-shell">
    <div class="warehouse-sidebar">
        <div class="warehouse-brand">📦 Quản lý kho</div>
        <a href="{{ route('warehouse.dashboard') }}"
           class="warehouse-link {{ request()->routeIs('warehouse.dashboard') ? 'active' : '' }}">
            <i class="bi bi-pie-chart"></i>
            <span>Tổng quan</span>
        </a>
        <a href="{{ route('warehouse.products.index') }}"
           class="warehouse-link {{ request()->routeIs('warehouse.products.index') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Sản phẩm</span>
        </a>

        <a href="{{ route('warehouse.products.create') }}"
           class="warehouse-link {{ request()->routeIs('warehouse.products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            <span>Thêm sản phẩm</span>
        </a>
           <a href="{{ route('warehouse.orders.index') }}"
           class="warehouse-link {{ request()->routeIs('warehouse.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span>Đơn hàng</span>
        </a>
        <a href="{{ route('users.index') }}"
           class="warehouse-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Quản lý Users</span>
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="warehouse-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="bi bi-star-half"></i>
            <span>Quản lý đánh giá</span>
        </a>

        <a href="{{ route('shop.index') }}" class="warehouse-link">
            <i class="bi bi-shop"></i>
            <span>Về cửa hàng</span>
        </a>
         
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-outline-light rounded-pill w-100">
                <i class="bi bi-box-arrow-left me-1"></i> Thoát kho
            </button>
        </form>
    </div>

    <div class="warehouse-main">
        @if(session('success'))
            <div class="alert alert-success rounded-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>