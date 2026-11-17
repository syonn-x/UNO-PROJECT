<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | U.N.O E-Commerce Rental</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #0369a1 0%, #1d4ed8 100%);
            color: #fff;
            transform: translateY(-1px);
        }
        .quick-btn {
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .brand-icon-box {
            width: 44px;
            height: 44px;
            background: #ffffff;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(226, 232, 240, 0.8);
            flex-shrink: 0;
        }
        .brand-logo-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<div class="p-3 w-100 d-flex justify-content-center">
    <div class="login-card">
        <div class="p-4 text-center border-bottom bg-light">
            <a href="{{ route('landing') }}" class="d-inline-flex align-items-center text-decoration-none">
                <div class="brand-icon-box mr-2">
                    <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
                </div>
                <div class="text-left">
                    <span class="font-weight-bold text-dark" style="font-size: 1.3rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                    <span class="d-block text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1.2px; font-weight: 700;">USE NOT OWN</span>
                </div>
            </a>
        </div>

        <div class="p-4">
            <h5 class="font-weight-bold text-dark mb-1">Masuk ke Akun Anda</h5>
            <p class="text-muted text-sm mb-4">Akses panel admin atau kelola transaksi rental Anda.</p>

            @if(session('success'))
                <div class="alert alert-success py-2 text-sm rounded-lg mb-3">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger py-2 text-sm rounded-lg mb-3">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 text-sm rounded-lg mb-3">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label class="text-xs font-weight-bold text-muted text-uppercase">Alamat Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                        </div>
                        <input type="email" name="email" class="form-control border-left-0" placeholder="admin@uno.com" value="{{ old('email', 'admin@uno.com') }}" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="text-xs font-weight-bold text-muted text-uppercase">Kata Sandi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-lock text-muted"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control border-left-0" placeholder="••••••••" value="admin123" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="custom-control custom-checkbox text-sm">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" checked>
                        <label class="custom-control-label text-muted" for="remember">Ingat Saya</label>
                    </div>
                    <a href="{{ route('landing') }}" class="text-sm text-primary font-weight-medium">Kembali ke Beranda</a>
                </div>

                <button type="submit" class="btn btn-gradient btn-block mb-3">
                    <i class="fas fa-sign-in-alt mr-1"></i> Masuk Sekarang
                </button>
            </form>

            <div class="text-center mb-3">
                <span class="text-sm text-muted">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-sm font-weight-bold text-primary ml-1">Daftar Akun Baru</a>
                <div class="mt-1">
                    <small class="text-muted">
                        Daftar sebagai <a href="{{ route('register') }}?role=renter" class="text-primary font-weight-semibold">Penyewa (Renter)</a> atau <a href="{{ route('register') }}?role=owner" class="text-warning font-weight-semibold">Mitra Owner</a>
                    </small>
                </div>
            </div>

            <div class="mt-3 pt-3 border-top text-center">
                <span class="text-xs text-muted font-weight-bold text-uppercase d-block mb-2">⚡ 1-Click Login Cepat Demo:</span>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('quick.login', 'admin') }}" class="btn btn-xs btn-outline-danger quick-btn m-1 px-2 py-1">
                        <i class="fas fa-user-shield mr-1"></i> Demo Admin
                    </a>
                    <a href="{{ route('quick.login', 'owner') }}" class="btn btn-xs btn-outline-warning text-dark quick-btn m-1 px-2 py-1">
                        <i class="fas fa-store mr-1"></i> Demo Mitra Owner
                    </a>
                    <a href="{{ route('quick.login', 'renter') }}" class="btn btn-xs btn-outline-primary quick-btn m-1 px-2 py-1">
                        <i class="fas fa-shopping-bag mr-1"></i> Demo Penyewa
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-light p-3 text-center text-xs text-muted border-top">
            Server Node: <code class="text-primary font-weight-bold">10.61.4.129</code> • U.N.O Rental Platform
        </div>
    </div>
</div>

</body>
</html>
