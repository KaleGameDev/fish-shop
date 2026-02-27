<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Fish Shop')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand:#0d6efd;
      --brand2:#14b8a6;
      --ink:#0f172a;
      --muted:#64748b;
      --card:#ffffff;
      --bg:#f6f7fb;
    }
    body{ font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto; background:var(--bg); color:var(--ink); }
    .nav-glass{
      background: rgba(255,255,255,.82);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(15,23,42,.06);
    }
    .brand-badge{
      width:40px;height:40px;border-radius:12px;
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      display:grid;place-items:center;color:#fff;font-weight:800;
      box-shadow: 0 10px 25px rgba(13,110,253,.20);
    }
    .hero{
      border-radius: 22px;
      background:
        radial-gradient(800px 300px at 20% 10%, rgba(20,184,166,.25), transparent 60%),
        radial-gradient(700px 300px at 80% 20%, rgba(13,110,253,.22), transparent 55%),
        linear-gradient(180deg, #ffffff, #fbfbff);
      border: 1px solid rgba(15,23,42,.06);
      box-shadow: 0 22px 55px rgba(2, 6, 23, .08);
      overflow:hidden;
      position:relative;
    }
    .hero:after{
      content:"";
      position:absolute; inset:-60px -60px auto auto;
      width:220px; height:220px; border-radius:999px;
      background: linear-gradient(135deg, rgba(13,110,253,.35), rgba(20,184,166,.25));
      filter: blur(0px);
      transform: rotate(18deg);
      opacity:.7;
    }
    .btn-brand{
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      border: none;
      box-shadow: 0 14px 30px rgba(13,110,253,.18);
    }
    .btn-brand:hover{ filter: brightness(.98); transform: translateY(-1px); }
    .search-pill{
      border-radius: 999px;
      border: 1px solid rgba(15,23,42,.10);
      background:#fff;
      box-shadow: 0 10px 25px rgba(2,6,23,.06);
    }
    .card-product{
      border: 1px solid rgba(15,23,42,.06);
      border-radius: 18px;
      overflow:hidden;
      background: var(--card);
      box-shadow: 0 12px 30px rgba(2,6,23,.06);
      transition: .2s ease;
      height: 100%;
    }
    .card-product:hover{ transform: translateY(-4px); box-shadow: 0 22px 55px rgba(2,6,23,.10); }
    .thumb{
      height: 210px; width:100%;
      object-fit: cover;
      background: #eef2ff;
    }
    .price{
      font-weight:800;
      background: rgba(20,184,166,.12);
      color: #0f766e;
      padding: .35rem .6rem;
      border-radius: 999px;
      border: 1px solid rgba(20,184,166,.20);
      white-space:nowrap;
    }
    .chip{
      font-size:.75rem;
      color: var(--muted);
      background: rgba(100,116,139,.10);
      border: 1px solid rgba(100,116,139,.18);
      padding: .25rem .5rem;
      border-radius: 999px;
    }
    .muted{ color: var(--muted); }
    .section-title{ font-weight:800; letter-spacing:-.02em; }
    .feature{
      border-radius: 18px;
      border: 1px solid rgba(15,23,42,.06);
      background: #fff;
      padding: 18px;
      box-shadow: 0 12px 30px rgba(2,6,23,.05);
      height:100%;
    }
    footer{
      border-top: 1px solid rgba(15,23,42,.06);
      background: #fff;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg nav-glass sticky-top">
  <div class="container py-2">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('shop.index') }}">
      <span class="brand-badge"></span>
      <span class="fw-extrabold" style="font-weight:800;">Fish Shop</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <form class="ms-lg-4 my-3 my-lg-0 w-100" method="GET" action="{{ route('shop.index') }}">
        <div class="input-group search-pill">
          <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-search"></i></span>
          <input class="form-control border-0" name="q" value="{{ request('q') }}" placeholder="Tìm cá: cá hồi, cá thu, cá ngừ...">
          <button class="btn btn-brand text-white rounded-pill px-4 me-2 my-2" type="submit">Tìm</button>
        </div>
      </form>

      <div class="nav-actions auth-wrap ms-lg-3">
        @auth
            <span class="d-none d-lg-inline muted">Xin chào, <b>{{ auth()->user()->name }}</b></span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-dark auth-btn">
                <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
                </button>
            </form>
            @else
            <a class="btn btn-outline-dark auth-btn" href="{{ route('login') }}">
                <i class="bi bi-person me-1"></i> Đăng nhập
            </a>
            <a class="btn btn-brand text-white auth-btn" href="{{ route('register') }}">
                <i class="bi bi-stars me-1"></i> Đăng ký
            </a>
            @endauth
      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
  @yield('content')
</main>

<footer>
  <div class="container py-4">
    <div class="row g-3 align-items-center">
      <div class="col-md-6">
        <div class="fw-bold">Fish Shop</div>
        <div class="muted">Cá tươi mỗi ngày • Giao nhanh • Đổi trả linh hoạt</div>
      </div>
      <div class="col-md-6 text-md-end muted">
        © {{ date('Y') }} Fish Shop • Hotline: 0123 456 789
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>