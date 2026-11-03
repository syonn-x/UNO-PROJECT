<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Katalog Sewa Barang | U.N.O Rental Platform</title>
    <meta name="description" content="Jelajahi seluruh katalog barang rental kamera, gadget, alat outdoor, dan kendaraan dengan sistem filter lengkap ala Tokopedia di U.N.O.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --primary-light: #e0f2fe;
            --tokopedia-green: #03ac0e;
            --tokopedia-green-light: #e8f8ea;
            --secondary: #6366f1;
            --accent: #f59e0b;
            --dark: #0f172a;
            --gray-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background-color: var(--gray-bg);
            overflow-x: hidden;
        }

        /* Navbar Tokopedia Style */
        .uno-nav {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1030;
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
            transition: transform 0.2s ease;
        }
        .brand-icon-box:hover {
            transform: scale(1.05);
        }
        .brand-logo-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        /* Search Bar in Header */
        .top-search-wrap {
            position: relative;
            flex-grow: 1;
            max-width: 580px;
        }

        .top-search-input {
            width: 100%;
            height: 42px;
            padding: 8px 45px 8px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.92rem;
            background-color: #f1f5f9;
            transition: all 0.2s ease;
        }

        .top-search-input:focus {
            background-color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
            outline: none;
        }

        .top-search-btn {
            position: absolute;
            right: 4px;
            top: 4px;
            height: 34px;
            width: 38px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border: none;
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .top-search-btn:hover {
            opacity: 0.9;
        }

        /* Breadcrumbs */
        .breadcrumb-wrap {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 10px 0;
            font-size: 0.86rem;
        }

        .breadcrumb-wrap a {
            color: #64748b;
            text-decoration: none;
        }

        .breadcrumb-wrap a:hover {
            color: var(--primary);
        }

        .breadcrumb-wrap .current {
            color: var(--dark);
            font-weight: 600;
        }

        /* Filter Sidebar */
        .filter-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 22px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            position: sticky;
            top: 90px;
        }

        .filter-section-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-divider {
            border-top: 1px solid #f1f5f9;
            margin: 18px 0;
        }

        .filter-link-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 10px;
            border-radius: 8px;
            color: #475569;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .filter-link-item:hover {
            background-color: #f1f5f9;
            color: var(--primary);
            text-decoration: none;
        }

        .filter-link-item.active {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 700;
        }

        .filter-chip-btn {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
            font-size: 0.82rem;
            margin: 3px 2px;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .filter-chip-btn:hover, .filter-chip-btn.active {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
            text-decoration: none;
        }

        /* Tokopedia Sort Tabs */
        .sort-pill {
            padding: 7px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            font-size: 0.86rem;
            font-weight: 500;
            text-decoration: none;
            margin-right: 6px;
            margin-bottom: 6px;
            display: inline-flex;
            align-items: center;
            transition: all 0.15s;
        }

        .sort-pill:hover {
            background: #f8fafc;
            color: var(--primary);
            border-color: #cbd5e1;
            text-decoration: none;
        }

        .sort-pill.active {
            background: #ffffff;
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 700;
            box-shadow: 0 0 0 1px var(--primary);
        }

        /* Active Filter Badges */
        .active-filter-badge {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .active-filter-badge a {
            color: #64748b;
            margin-left: 6px;
            text-decoration: none;
        }

        .active-filter-badge a:hover {
            color: #ef4444;
        }

        /* Product Cards Tokopedia Style */
        .tokopedia-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .tokopedia-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .card-img-wrap {
            position: relative;
            width: 100%;
            padding-top: 100%; /* 1:1 Aspect Ratio like Tokopedia */
            background-color: #f8fafc;
            overflow: hidden;
        }

        .card-img-wrap img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .tokopedia-card:hover .card-img-wrap img {
            transform: scale(1.04);
        }

        .badge-condition-pill {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(15, 23, 42, 0.8);
            color: #ffffff;
            backdrop-filter: blur(4px);
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
        }

        .badge-cat-pill {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(2, 132, 199, 0.9);
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            z-index: 2;
        }

        .tokopedia-card-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .tokopedia-card-title {
            font-size: 0.94rem;
            font-weight: 600;
            line-height: 1.35;
            color: #1e293b;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 38px;
            margin-bottom: 6px;
            text-decoration: none;
        }

        .tokopedia-card-title:hover {
            color: var(--primary);
            text-decoration: none;
        }

        .tokopedia-card-price {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .tokopedia-card-price small {
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 500;
        }

        .tokopedia-card-location {
            font-size: 0.78rem;
            color: #64748b;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
        }

        .tokopedia-card-stats {
            font-size: 0.75rem;
            color: #64748b;
            display: flex;
            align-items: center;
            margin-top: auto;
            padding-top: 8px;
            border-top: 1px dashed #e2e8f0;
        }

        .btn-sewa-card {
            border-radius: 8px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.82rem;
            padding: 6px 12px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-sewa-card:hover {
            color: #ffffff;
            opacity: 0.95;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
            text-decoration: none;
        }

        /* Empty State */
        .empty-state-box {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 50px 20px;
            text-align: center;
        }

        /* Pagination Tokopedia Style */
        .page-link {
            border-radius: 8px !important;
            margin: 0 3px;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 8px 14px;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border-color: #0284c7;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);
        }

        .page-item.disabled .page-link {
            color: #cbd5e1;
            background-color: #ffffff;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: #94a3b8;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<!-- Header / Navigation Bar (Tokopedia Style with Centered Search) -->
<nav class="navbar navbar-expand-lg uno-nav py-2">
    <div class="container-fluid px-lg-5">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center text-decoration-none mr-4" href="{{ route('landing') }}">
            <div class="brand-icon-box mr-2">
                <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
            </div>
            <div>
                <span class="font-weight-bold text-dark" style="font-size: 1.25rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                <span class="d-block text-muted text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.2px; font-weight: 700;">USE NOT OWN</span>
            </div>
        </a>

        <!-- Search Bar Tokopedia Style -->
        <form action="{{ route('catalog') }}" method="GET" class="top-search-wrap d-none d-md-block mr-4">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <input type="text" name="q" class="top-search-input" placeholder="Cari barang sewa, kamera, drone, tenda, gadget..." value="{{ request('q') }}">
            <button type="submit" class="top-search-btn" title="Cari">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Navbar Toggle for Mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent">
            <i class="fas fa-bars text-dark"></i>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-semibold text-dark px-3" href="{{ route('landing') }}">
                        <i class="fas fa-home text-muted mr-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-primary px-3" href="{{ route('catalog') }}">
                        <i class="fas fa-th-large text-primary mr-1"></i> Katalog Sewa
                    </a>
                </li>
            </ul>

            <!-- Mobile Search Bar -->
            <form action="{{ route('catalog') }}" method="GET" class="d-block d-md-none my-3">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari barang rental..." value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>

            <!-- User Auth Buttons -->
            <!-- User Auth Buttons -->
            <div class="d-flex align-items-center">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm font-weight-bold text-white mr-2 px-3 py-2 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                            <i class="fas fa-user-shield mr-1"></i> Dashboard Admin
                        </a>
                    @endif
                    <div class="dropdown mr-2">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center border px-3 py-1 shadow-sm" type="button" id="userMenuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 12px; background: #ffffff;">
                            <img src="{{ Auth::user()->avatar_url }}" 
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0284c7&color=fff';"
                                 class="rounded-circle mr-2" style="width: 28px; height: 28px; object-fit: cover;" alt="{{ Auth::user()->name }}">
                            <div class="text-left mr-1">
                                <div class="font-weight-bold text-dark text-xs" style="line-height: 1.1;">{{ Str::limit(Auth::user()->name, 14) }}</div>
                                <span class="badge {{ Auth::user()->isOwner() ? 'badge-warning text-dark' : 'badge-primary text-white' }}" style="font-size: 0.62rem; padding: 1px 5px;">
                                    {{ Auth::user()->isOwner() ? 'Mitra Owner' : 'Penyewa' }}
                                </span>
                            </div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-2" aria-labelledby="userMenuDropdown" style="border-radius: 14px; min-width: 220px; z-index: 1060;">
                            <div class="px-3 py-2 border-bottom mb-2 bg-light rounded">
                                <div class="font-weight-bold text-dark text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-muted text-xs text-truncate">{{ Auth::user()->email }}</div>
                                <span class="badge badge-success text-xs mt-1"><i class="fas fa-check-circle mr-1"></i> {{ Auth::user()->role_label }}</span>
                            </div>
                            <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'profile']) }}">
                                <i class="fas fa-user-circle text-primary mr-2"></i> Profil & Akun Saya
                            </a>
                            <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'rentals']) }}">
                                <i class="fas fa-box text-success mr-2"></i> Riwayat Sewa Saya
                            </a>
                            <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'favorites']) }}">
                                <i class="fas fa-heart text-danger mr-2"></i> Wishlist Favorit
                            </a>
                            @if(Auth::user()->isOwner())
                                <div class="dropdown-divider my-2"></div>
                                <h6 class="dropdown-header text-xs text-uppercase font-weight-bold text-muted px-3">Mitra Rental (Owner)</h6>
                                <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'my-items']) }}">
                                    <i class="fas fa-store text-warning mr-2"></i> Unit Rental Saya
                                </a>
                                <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'incoming-bookings']) }}">
                                    <i class="fas fa-bell text-info mr-2"></i> Pesanan Sewa Masuk
                                </a>
                                <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'add-item']) }}">
                                    <i class="fas fa-plus-circle text-success mr-2"></i> Tambah Unit Rental
                                </a>
                            @endif
                            <div class="dropdown-divider my-2"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 rounded font-weight-medium text-danger">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm font-weight-bold text-dark mr-2 px-3 py-2 border" style="border-radius: 10px;">
                        <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}?role=renter" class="btn btn-primary btn-sm font-weight-bold text-white px-3 py-2 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                        <i class="fas fa-user-plus mr-1"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Breadcrumb Strip -->
<div class="breadcrumb-wrap">
    <div class="container-fluid px-lg-5">
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('landing') }}"><i class="fas fa-home mr-1"></i> Beranda</a>
            <span class="mx-2 text-muted">/</span>
            <a href="{{ route('catalog') }}" class="{{ !request('category') && !request('q') ? 'current' : '' }}">Katalog Sewa</a>
            @if($activeCategory)
                <span class="mx-2 text-muted">/</span>
                <span class="current">{{ $activeCategory->name }}</span>
            @endif
            @if(request('q'))
                <span class="mx-2 text-muted">/</span>
                <span class="text-muted">Pencarian: "<strong>{{ request('q') }}</strong>"</span>
            @endif
        </div>
    </div>
</div>

<!-- Main Catalog Container (Tokopedia 2-Column Layout) -->
<div class="container-fluid px-lg-5 py-4">
    <div class="row">
        
        <!-- LEFT COLUMN: Filter Sidebar (Tokopedia Style) -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="filter-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.1rem;">
                        <i class="fas fa-sliders-h mr-2 text-primary"></i> Filter
                    </h5>
                    @if(request()->hasAny(['q', 'category', 'location', 'condition', 'min_price', 'max_price', 'min_rating', 'sort']))
                        <a href="{{ route('catalog') }}" class="text-xs text-danger font-weight-bold text-decoration-none">
                            Reset Semua
                        </a>
                    @endif
                </div>

                <!-- Form Filter -->
                <form id="filterForm" action="{{ route('catalog') }}" method="GET">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Filter 1: Kategori -->
                    <div class="filter-section-title">
                        <span><i class="fas fa-tags text-muted mr-1"></i> Kategori</span>
                    </div>
                    <div class="mb-3">
                        <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}" 
                           class="filter-link-item {{ !request('category') ? 'active' : '' }}">
                            <span>Semua Kategori</span>
                            <span class="badge badge-light border">{{ $categories->sum('items_count') }}</span>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->id, 'page' => null]) }}" 
                               class="filter-link-item {{ request('category') == $cat->id ? 'active' : '' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="badge badge-light border">{{ $cat->items_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="filter-divider"></div>

                    <!-- Filter 2: Lokasi / Kota -->
                    <div class="filter-section-title">
                        <span><i class="fas fa-map-marker-alt text-muted mr-1"></i> Lokasi</span>
                    </div>
                    <div class="mb-3">
                        <select name="location" class="form-control form-control-sm border bg-light" style="border-radius: 8px;" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Semua Lokasi / Kota</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                    {{ $loc }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-divider"></div>

                    <!-- Filter 3: Rentang Harga Sewa (Rp) -->
                    <div class="filter-section-title">
                        <span><i class="fas fa-money-bill-wave text-muted mr-1"></i> Harga Sewa / Hari</span>
                    </div>
                    <div class="mb-2">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-muted border-right-0">Rp</span>
                            </div>
                            <input type="number" name="min_price" class="form-control" placeholder="Harga Minimum" value="{{ request('min_price') }}">
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-muted border-right-0">Rp</span>
                            </div>
                            <input type="number" name="max_price" class="form-control" placeholder="Harga Maksimum" value="{{ request('max_price') }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm btn-block font-weight-bold" style="border-radius: 8px;">
                            Terapkan Harga
                        </button>
                    </div>

                    <div class="filter-divider"></div>

                    <!-- Filter 4: Kondisi Barang -->
                    <div class="filter-section-title">
                        <span><i class="fas fa-certificate text-muted mr-1"></i> Kondisi Unit</span>
                    </div>
                    <div class="mb-3">
                        @php
                            $conditions = [
                                'like_new' => 'Like New (Mulus)',
                                'good' => 'Bagus (Good)',
                                'fair' => 'Layak Pakai',
                                'new' => 'Baru'
                            ];
                        @endphp
                        @foreach($conditions as $cKey => $cLabel)
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="cond_{{ $cKey }}" name="condition" value="{{ $cKey }}" class="custom-control-input" {{ request('condition') == $cKey ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                <label class="custom-control-label text-sm text-secondary" for="cond_{{ $cKey }}">{{ $cLabel }}</label>
                            </div>
                        @endforeach
                        @if(request('condition'))
                            <a href="{{ request()->fullUrlWithQuery(['condition' => null]) }}" class="text-xs text-muted">
                                <i class="fas fa-times-circle mr-1"></i> Hapus filter kondisi
                            </a>
                        @endif
                    </div>

                    <div class="filter-divider"></div>

                    <!-- Filter 5: Rating Bintang -->
                    <div class="filter-section-title">
                        <span><i class="fas fa-star text-warning mr-1"></i> Rating Ulasan</span>
                    </div>
                    <div>
                        <a href="{{ request()->fullUrlWithQuery(['min_rating' => 4.5, 'page' => null]) }}" class="filter-chip-btn {{ request('min_rating') == '4.5' ? 'active' : '' }}">
                            <i class="fas fa-star text-warning"></i> 4.5+ Bintang
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_rating' => 4.0, 'page' => null]) }}" class="filter-chip-btn {{ request('min_rating') == '4.0' ? 'active' : '' }}">
                            <i class="fas fa-star text-warning"></i> 4.0+ Bintang
                        </a>
                        @if(request('min_rating'))
                            <a href="{{ request()->fullUrlWithQuery(['min_rating' => null]) }}" class="filter-chip-btn text-danger">
                                <i class="fas fa-times"></i> Hapus
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT COLUMN: Products Grid & Sort (Tokopedia Style) -->
        <div class="col-lg-9 col-md-8">
            
            <!-- Result Title & Sort Bar -->
            <div class="bg-white p-3 rounded-lg border mb-3 shadow-sm" style="border-radius: 12px !important;">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="mb-2 mb-md-0">
                        <h4 class="font-weight-bold text-dark mb-1" style="font-size: 1.35rem;">
                            @if(request('q'))
                                Hasil Pencarian "{{ request('q') }}"
                            @elseif($activeCategory)
                                Katalog {{ $activeCategory->name }}
                            @else
                                Seluruh Katalog Rental
                            @endif
                        </h4>
                        <div class="text-muted text-xs">
                            Menampilkan <strong>{{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }}</strong> dari <strong>{{ $items->total() }}</strong> unit rental
                        </div>
                    </div>

                    <!-- Tokopedia Sort Buttons -->
                    <div class="d-flex align-items-center flex-wrap">
                        <span class="text-xs text-muted font-weight-bold text-uppercase mr-2">Urutkan:</span>
                        <div class="d-flex flex-wrap">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular', 'page' => null]) }}" class="sort-pill {{ request('sort') == 'popular' || !request('sort') ? 'active' : '' }}">
                                Paling Sesuai
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc', 'page' => null]) }}" class="sort-pill {{ request('sort') == 'price_asc' ? 'active' : '' }}">
                                Harga Terendah
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc', 'page' => null]) }}" class="sort-pill {{ request('sort') == 'price_desc' ? 'active' : '' }}">
                                Harga Tertinggi
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest', 'page' => null]) }}" class="sort-pill {{ request('sort') == 'latest' ? 'active' : '' }}">
                                Terbaru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Filter Tags Strip -->
                @if(request()->hasAny(['q', 'category', 'location', 'condition', 'min_price', 'max_price', 'min_rating']))
                <div class="pt-3 mt-3 border-top d-flex align-items-center flex-wrap">
                    <span class="text-xs text-muted mr-2">Filter aktif:</span>
                    
                    @if(request('q'))
                        <span class="active-filter-badge">
                            Kata Kunci: "{{ request('q') }}"
                            <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    @if($activeCategory)
                        <span class="active-filter-badge">
                            Kategori: {{ $activeCategory->name }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    @if(request('location'))
                        <span class="active-filter-badge">
                            Lokasi: {{ request('location') }}
                            <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    @if(request('min_price'))
                        <span class="active-filter-badge">
                            Min: Rp {{ number_format(request('min_price'), 0, ',', '.') }}
                            <a href="{{ request()->fullUrlWithQuery(['min_price' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    @if(request('max_price'))
                        <span class="active-filter-badge">
                            Maks: Rp {{ number_format(request('max_price'), 0, ',', '.') }}
                            <a href="{{ request()->fullUrlWithQuery(['max_price' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    @if(request('condition'))
                        <span class="active-filter-badge">
                            Kondisi: {{ ucfirst(str_replace('_', ' ', request('condition'))) }}
                            <a href="{{ request()->fullUrlWithQuery(['condition' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    @if(request('min_rating'))
                        <span class="active-filter-badge">
                            Rating: {{ request('min_rating') }}+
                            <a href="{{ request()->fullUrlWithQuery(['min_rating' => null]) }}" title="Hapus">&times;</a>
                        </span>
                    @endif

                    <a href="{{ route('catalog') }}" class="text-xs text-danger font-weight-bold ml-2">
                        Hapus Semua Filter
                    </a>
                </div>
                @endif
            </div>

            <!-- Product Cards Grid (Tokopedia Style 3-Column) -->
            <div class="row">
                @forelse($items as $item)
                <div class="col-6 col-md-4 col-xl-4 mb-4">
                    <div class="tokopedia-card">
                        <div class="card-img-wrap">
                            <a href="{{ route('items.show', $item->id) }}" class="d-block w-100 h-100">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy">
                            </a>
                            @php
                                $condMap = [
                                    'new' => 'Baru',
                                    'like_new' => 'Like New',
                                    'good' => 'Bagus',
                                    'fair' => 'Layak Pakai'
                                ];
                            @endphp
                            <span class="badge-condition-pill">{{ $condMap[$item->condition] ?? 'Normal' }}</span>
                            <span class="badge-cat-pill">{{ $item->category->name }}</span>
                        </div>

                        <div class="tokopedia-card-body">
                            <!-- Product Title -->
                            <a href="{{ route('items.show', $item->id) }}" class="tokopedia-card-title" title="{{ $item->name }}">
                                {{ $item->name }}
                            </a>

                            <!-- Price per day -->
                            <div class="tokopedia-card-price">
                                Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                                <small>/ hari</small>
                            </div>

                            <!-- Location & Shop -->
                            <div class="tokopedia-card-location">
                                <i class="fas fa-map-marker-alt text-danger mr-1"></i> 
                                <span class="text-truncate">{{ $item->location }}</span>
                            </div>

                            <!-- Rating & Reviews -->
                            <div class="tokopedia-card-stats justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning mr-1"></i>
                                    <span class="font-weight-bold text-dark mr-1">{{ number_format($item->avg_rating, 1) }}</span>
                                    <span class="text-muted text-xs">({{ $item->reviews_count }})</span>
                                </div>
                                <a href="{{ route('items.show', $item->id) }}" class="btn-sewa-card">
                                    Sewa <i class="fas fa-arrow-right text-xs ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Empty State -->
                <div class="col-12 py-4">
                    <div class="empty-state-box">
                        <i class="fas fa-search-minus fa-4x text-muted mb-3"></i>
                        <h4 class="font-weight-bold text-dark mb-2">Barang yang kamu cari tidak ditemukan</h4>
                        <p class="text-muted max-w-md mx-auto mb-4" style="max-width: 480px;">
                            Coba periksa ejaan kata kunci kamu, atau reset pilihan filter kategori, rentang harga, dan lokasi.
                        </p>
                        <a href="{{ route('catalog') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px;">
                            <i class="fas fa-undo mr-1"></i> Reset Semua Filter
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination Tokopedia Style -->
            @if($items->hasPages())
            <div class="d-flex justify-content-center mt-4 mb-5">
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Footer -->
<footer class="pt-5 pb-4 border-top">
    <div class="container-fluid px-lg-5">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="brand-icon-box mr-2">
                        <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
                    </div>
                    <div>
                        <span class="font-weight-bold text-white" style="font-size: 1.25rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                        <span class="d-block text-white-50 text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.2px; font-weight: 700;">USE NOT OWN</span>
                    </div>
                </div>
                <p class="text-muted text-sm mb-3">
                    Platform sewa barang online modern bergaya Tokopedia. Akses ribuan alat profesional tanpa modal besar.
                </p>
                <div class="text-xs text-white-50">
                    Host Server IP: <strong class="text-info font-monospace">10.61.4.129</strong> • Port 8000
                </div>
            </div>
            <div class="col-lg-3 col-6 mb-4 mb-lg-0">
                <h6 class="text-white font-weight-bold mb-3">Kategori Pilihan</h6>
                <ul class="list-unstyled text-sm">
                    @foreach($categories->take(5) as $c)
                        <li class="mb-2">
                            <a href="{{ route('catalog', ['category' => $c->id]) }}" class="text-muted">
                                {{ $c->name }} ({{ $c->items_count }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                <h6 class="text-white font-weight-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled text-sm">
                    <li class="mb-2"><a href="{{ route('landing') }}" class="text-muted">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('catalog') }}" class="text-muted">Katalog Lengkap</a></li>
                    <li class="mb-2"><a href="{{ route('landing') }}#how-it-works" class="text-muted">Cara Kerja</a></li>
                    <li class="mb-2"><a href="{{ route('landing') }}#reviews" class="text-muted">Testimoni</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white font-weight-bold mb-3">Mulai Menyewa</h6>
                <p class="text-muted text-xs mb-3">Temukan barang yang kamu butuhkan sekarang atau sewakan barangmu dan raih penghasilan tambahan.</p>
                <a href="{{ route('register') }}?role=owner" class="btn btn-outline-info btn-sm btn-block font-weight-bold" style="border-radius: 8px;">
                    <i class="fas fa-handshake mr-1"></i> Daftar Mitra Owner
                </a>
            </div>
        </div>

        <div class="pt-4 mt-4 border-top border-secondary text-center text-xs text-muted">
            &copy; {{ date('Y') }} U.N.O (USE NOT OWN) Rental Platform. Semua hak cipta dilindungi.
        </div>
    </div>
</footer>

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
