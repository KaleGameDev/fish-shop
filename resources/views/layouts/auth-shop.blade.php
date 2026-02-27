<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Fish Shop - Auth')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    body{ font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto; background:#f6f7fb; }
    .auth-wrap{
      min-height:100vh;
      background:
        radial-gradient(900px 340px at 20% 8%, rgba(20,184,166,.18), transparent 60%),
        radial-gradient(900px 340px at 80% 12%, rgba(13,110,253,.16), transparent 55%);
    }
    .auth-card{
      border:1px solid rgba(15,23,42,.08);
      border-radius: 22px;
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(10px);
      box-shadow: 0 24px 70px rgba(2,6,23,.12);
      overflow:hidden;
    }
    .brand-badge{
      width:46px;height:46px;border-radius:14px;
      background: linear-gradient(135deg, #0d6efd, #14b8a6);
      display:grid;place-items:center;color:#fff;font-weight:800;
      box-shadow: 0 16px 40px rgba(13,110,253,.22);
    }
    .btn-brand{
      background: linear-gradient(135deg, #0d6efd, #14b8a6);
      border:none;
      box-shadow: 0 14px 30px rgba(13,110,253,.18);
    }
    .btn-brand:hover{ filter: brightness(.98); transform: translateY(-1px); }
    .form-control{ border-radius: 14px; padding: .75rem .9rem; }
    .form-control:focus{ box-shadow: 0 0 0 .25rem rgba(13,110,253,.15); }
    .muted{ color:#64748b; }
    .side{
      background:
        radial-gradient(520px 240px at 50% 30%, rgba(20,184,166,.25), transparent 60%),
        radial-gradient(520px 240px at 50% 70%, rgba(13,110,253,.20), transparent 60%),
        linear-gradient(180deg, #0b1220, #0f172a);
      color:#e2e8f0;
      padding: 32px;
      height:100%;
    }
    .chip{
      display:inline-flex; align-items:center; gap:.4rem;
      font-size:.8rem;
      padding:.35rem .6rem;
      border-radius:999px;
      background: rgba(255,255,255,.10);
      border:1px solid rgba(255,255,255,.14);
    }
    a{ text-decoration:none; }
  </style>
</head>
<body>

<div class="auth-wrap d-flex align-items-center py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-9">
        <div class="auth-card">
          <div class="row g-0">
            <div class="col-md-5 d-none d-md-block">
              <div class="side d-flex flex-column justify-content-between">
                <div>
                  <div class="d-flex align-items-center gap-2 mb-4">
                    <div class="brand-badge">🐟</div>
                    <div>
                      <div class="fw-bold fs-5">Fish Shop</div>
                      <div class="muted" style="color:#94a3b8;">Cá tươi mỗi ngày</div>
                    </div>
                  </div>

                  <div class="chip mb-2"><i class="bi bi-truck"></i> Giao nhanh 30–60p</div><br>
                  <div class="chip mb-2"><i class="bi bi-shield-check"></i> Đảm bảo tươi</div><br>
                  <div class="chip"><i class="bi bi-arrow-repeat"></i> Đổi trả 24h</div>
                </div>

                <a href="{{ route('shop.index') }}" class="text-white-50">
                  <i class="bi bi-arrow-left"></i> Quay lại cửa hàng
                </a>
              </div>
            </div>

            <div class="col-md-7 p-4 p-md-5">
              @yield('content')
            </div>
          </div>
        </div>

        <div class="text-center muted small mt-3">
          © {{ date('Y') }} Fish Shop • Demo Laravel
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>