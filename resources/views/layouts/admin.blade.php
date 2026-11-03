<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | U.N.O Rental Platform</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Font: Source Sans Pro & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Theme style (AdminLTE 3.2.0) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Hotwire Turbo for instant SPA navigation -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js"></script>

    <style>
        body {
            font-family: 'Outfit', 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
        }
        .main-sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .brand-link {
            border-bottom: 1px solid rgba(255,255,255,0.08) !important;
            padding: 0.85rem 0.8rem !important;
            height: 57px;
            display: flex;
            align-items: center;
            overflow: hidden;
            transition: width 0.3s ease-in-out;
        }
        .brand-link .brand-image {
            float: left;
            margin-right: 0.65rem;
            margin-left: 0.25rem;
            margin-top: 0;
            max-height: 34px;
        }
        .brand-text {
            font-weight: 700 !important;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            white-space: nowrap;
        }
        .nav-header {
            font-size: 0.68rem !important;
            letter-spacing: 1.2px !important;
            text-transform: uppercase !important;
            font-weight: 800 !important;
            color: #64748b !important;
            padding: 0.9rem 1rem 0.3rem 1rem !important;
        }
        .nav-sidebar .nav-item > .nav-link {
            border-radius: 8px;
            margin: 2px 8px;
            padding: 0.55rem 0.85rem;
            color: #cbd5e1;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        .nav-sidebar .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }
        .nav-sidebar .nav-item > .nav-link.active {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
        .nav-sidebar .nav-link .nav-icon {
            font-size: 1rem;
            width: 1.6rem;
            text-align: center;
            margin-right: 0.4rem;
            flex-shrink: 0;
        }
        .nav-sidebar .nav-link p {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 1 1 auto;
            min-width: 0;
            margin: 0;
            line-height: 1.3;
            font-size: 0.92rem;
            gap: 8px;
        }
        .nav-sidebar .nav-link p .badge,
        .nav-sidebar .nav-link .badge.right {
            position: static !important;
            margin-left: auto !important;
            margin-top: 0 !important;
            float: none !important;
            flex-shrink: 0 !important;
            font-size: 0.72rem;
            padding: 0.26rem 0.55rem;
            border-radius: 6px;
            letter-spacing: 0.2px;
        }

        /* AdminLTE Sidebar Mini & Collapsed Mode (when NOT hovered) */
        .sidebar-collapse .main-sidebar:not(:hover) .brand-link {
            width: 4.6rem !important;
            padding: 0.85rem 0 !important;
            justify-content: center !important;
            text-align: center !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .brand-link .brand-image {
            float: none !important;
            margin: 0 auto !important;
            display: inline-block !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .brand-link .brand-text {
            display: none !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .user-panel {
            padding-left: 0 !important;
            padding-right: 0 !important;
            justify-content: center !important;
            text-align: center !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .user-panel .image {
            float: none !important;
            padding: 0 !important;
            margin: 0 auto !important;
            text-align: center !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .user-panel .image img {
            margin: 0 auto !important;
            display: block !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .user-panel .info {
            display: none !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .nav-header {
            display: none !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-item {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-item > .nav-link {
            width: 42px !important;
            height: 42px !important;
            margin: 4px auto !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 10px !important;
            transform: none !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-link .nav-icon {
            margin: 0 !important;
            width: auto !important;
            font-size: 1.1rem !important;
            text-align: center !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-link p {
            display: none !important;
        }

        /* When hovered in Mini mode (Flyout expansion to 250px) */
        .sidebar-collapse .main-sidebar:hover .brand-link {
            width: 250px !important;
            padding: 0.85rem 0.8rem !important;
            justify-content: flex-start !important;
        }
        .sidebar-collapse .main-sidebar:hover .brand-link .brand-image {
            float: left !important;
            margin-right: 0.65rem !important;
            margin-left: 0.25rem !important;
            display: block !important;
        }
        .sidebar-collapse .main-sidebar:hover .brand-link .brand-text {
            display: inline-block !important;
        }
        .sidebar-collapse .main-sidebar:hover .user-panel {
            padding-left: 0.8rem !important;
            padding-right: 0.8rem !important;
            justify-content: flex-start !important;
        }
        .sidebar-collapse .main-sidebar:hover .user-panel .image {
            float: left !important;
            margin-right: 0.6rem !important;
        }
        .sidebar-collapse .main-sidebar:hover .user-panel .info {
            display: block !important;
        }
        .sidebar-collapse .main-sidebar:hover .nav-header {
            display: block !important;
        }
        .sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-link p {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            gap: 8px !important;
        }
        .sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-item {
            display: block !important;
            width: 100% !important;
        }
        .sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-item > .nav-link {
            width: auto !important;
            height: auto !important;
            margin: 2px 8px !important;
            padding: 0.5rem 0.8rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
        }
        .sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-link .nav-icon {
            margin-right: 0.5rem !important;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.07);
        }
        .card-header {
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
        }
        .small-box {
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transition: all 0.25s ease;
        }
        .small-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.15);
        }
        .small-box .icon > i {
            font-size: 65px;
            opacity: 0.25;
            transition: all 0.3s linear;
        }
        .small-box:hover .icon > i {
            font-size: 72px;
            opacity: 0.4;
        }
        .badge-status {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .badge-available { background-color: #dcfce7; color: #15803d; }
        .badge-unavailable { background-color: #fee2e2; color: #b91c1c; }
        .badge-hidden { background-color: #f1f5f9; color: #475569; }
        .badge-pending { background-color: #fef3c7; color: #b45309; }
        .badge-confirmed { background-color: #e0f2fe; color: #0369a1; }
        .badge-completed { background-color: #dcfce7; color: #15803d; }
        .badge-cancelled { background-color: #fee2e2; color: #b91c1c; }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0369a1 0%, #1d4ed8 100%);
        }
        .table thead th {
            border-top: none;
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        /* Modern Minimalist Stat Card */
        .modern-stat-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            padding: 1.35rem 1.4rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .modern-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }
        .modern-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .modern-segmented-tab {
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
            display: inline-flex;
            gap: 4px;
        }
        .modern-segmented-tab .btn {
            border-radius: 8px !important;
            padding: 0.4rem 1rem !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            border: none !important;
            color: #64748b !important;
            background: transparent !important;
            transition: all 0.2s ease;
        }
        .modern-segmented-tab .btn.active,
        .modern-segmented-tab .btn:hover {
            background: #ffffff !important;
            color: #0f172a !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06) !important;
        }
        /* Pagination Styling & SVG Constraint */
        .pagination {
            display: flex !important;
            list-style: none !important;
            padding-left: 0 !important;
            border-radius: 8px !important;
            gap: 4px !important;
            margin: 0 !important;
            align-items: center !important;
        }
        .pagination .page-item .page-link {
            border-radius: 6px !important;
            padding: 0.35rem 0.75rem !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            color: #334155 !important;
            border: 1px solid #e2e8f0 !important;
        }
        .pagination .page-item.active .page-link {
            background-color: #0284c7 !important;
            border-color: #0284c7 !important;
            color: #ffffff !important;
        }
        .pagination svg,
        nav[role="navigation"] svg,
        .page-link svg {
            width: 14px !important;
            height: 14px !important;
            max-width: 14px !important;
            max-height: 14px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
    </style>
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

    <!-- Clean Modern Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom shadow-xs py-2 px-3">
        <!-- Left navbar links -->
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link text-dark p-2" data-widget="pushmenu" href="#" role="button" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-inline-block ml-2">
                <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Portal Admin Pusat</span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- Open Main Website -->
            <li class="nav-item mr-2">
                <a href="{{ route('landing') }}" target="_blank" class="btn btn-sm btn-outline-secondary font-weight-semibold px-3 py-1" style="border-radius: 8px; font-size: 0.82rem;">
                    <i class="fas fa-external-link-alt mr-1 text-xs"></i> Buka Website
                </a>
            </li>

            <!-- Notifications Dropdown (Safety & Security Alerts) -->
            <li class="nav-item dropdown mr-2">
                <a class="nav-link position-relative p-2" data-toggle="dropdown" href="#" title="Pesan & Aduan Keamanan">
                    <i class="far fa-bell" style="font-size: 1.15rem; color: #475569;"></i>
                    @php
                        $alertCount = \App\Models\SafetyReport::where('status', 'pending')->count();
                    @endphp
                    @if($alertCount > 0)
                        <span class="badge badge-danger position-absolute" style="top: 2px; right: 2px; font-size: 0.65rem; border-radius: 50%; min-width: 17px; height: 17px; display: flex; align-items: center; justify-content: center; padding: 0;">{{ $alertCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-sm rounded-lg border-0 mt-2">
                    <div class="p-3 bg-light border-bottom">
                        <h6 class="font-weight-bold mb-0 text-dark text-sm"><i class="fas fa-shield-alt text-danger mr-1"></i> Aduan Penipuan Pengguna</h6>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('admin.messages.index', ['status' => 'pending']) }}" class="dropdown-item rounded p-2">
                            <div class="font-weight-bold text-sm text-dark">{{ $alertCount }} Laporan Baru</div>
                            <small class="text-muted">Aduan korban butuh respon cepat & investigasi</small>
                        </a>
                    </div>
                    <div class="dropdown-divider m-0"></div>
                    <a href="{{ route('admin.messages.index') }}" class="dropdown-item text-center text-primary font-weight-bold text-xs py-2">Lihat Semua Pesan Masuk →</a>
                </div>
            </li>

            <!-- User Account Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center p-1" data-toggle="dropdown">
                    <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;" alt="Avatar">
                    <span class="d-none d-md-inline font-weight-semibold ml-2 text-dark text-sm">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down text-xs text-muted ml-1 d-none d-md-inline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow-sm rounded-lg border-0 mt-2 p-2" style="min-width: 200px;">
                    <div class="px-3 py-2 border-bottom mb-2">
                        <div class="font-weight-bold text-dark text-sm">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-xs text-muted">{{ auth()->user()->email }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger rounded font-weight-semibold text-sm py-2">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar (Logout)
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container (Grouped Sidebar) -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center py-2" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
            <div class="mr-2 ml-2" style="width: 36px; height: 36px; background: #ffffff; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.15); flex-shrink: 0;">
                <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" style="width: 26px; height: 26px; object-fit: contain;">
            </div>
            <div>
                <span class="brand-text font-weight-bold text-white d-block" style="font-size: 1.15rem; letter-spacing: -0.5px; line-height: 1.1;">U.N.O</span>
                <span class="d-block text-white-50 text-uppercase" style="font-size: 0.58rem; letter-spacing: 1px; font-weight: 700;">USE NOT OWN</span>
            </div>
        </a>

        <!-- Sidebar -->
        <div class="sidebar px-2">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-2 d-flex align-items-center" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="image">
                    <img src="{{ auth()->user()->avatar_url }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0284c7&color=fff';" class="img-circle elevation-1" style="width: 34px; height: 34px; object-fit: cover;" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block text-white font-weight-semibold">{{ auth()->user()->name ?? 'Admin Pusat' }}</a>
                    <span class="badge badge-success badge-sm" style="font-size: 0.65rem;"><i class="fas fa-circle mr-1" style="font-size: 6px;"></i> Online ({{ auth()->user()->role ?? 'admin' }})</span>
                </div>
            </div>

            <!-- Sidebar Menu (KELOMPOK SIDEBAR) -->
            <!-- Sidebar Menu (SUPER SIMPEL: DASHBOARD, PESAN PENIPUAN, DATA PENGGUNA & KTP) -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-header font-weight-bold" style="letter-spacing: 1px;">MENU ADMIN PUSAT</li>

                    <!-- 1. Dashboard Ringkas -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                            <p>Dashboard Ringkas</p>
                        </a>
                    </li>

                    <!-- 2. Pesan Aduan Penipuan (Messages) -->
                    <li class="nav-item">
                        <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') || request()->routeIs('admin.safety-reports.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope-open-text text-danger"></i>
                            <p>
                                <span>Pesan Masuk</span>
                                @php
                                    $pendingFraudCount = \App\Models\SafetyReport::where('status', 'pending')->count();
                                @endphp
                                @if($pendingFraudCount > 0)
                                    <span class="badge badge-danger right">{{ $pendingFraudCount }} Baru</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <!-- 3. Data Pengguna & Mitra -->
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users text-primary"></i>
                            <p>Data Pengguna & Mitra</p>
                        </a>
                    </li>

                    <li class="nav-header" style="letter-spacing: 1px;">PORTAL</li>
                    <li class="nav-item mb-4">
                        <a href="{{ route('landing') }}" target="_blank" class="nav-link">
                            <i class="nav-icon fas fa-external-link-alt text-success"></i>
                            <p>Buka Halaman Utama</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header py-3">
            <div class="container-fluid">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h1 class="m-0 font-weight-bold text-dark" style="font-size: 1.45rem; letter-spacing: -0.4px;">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div>
                        <ol class="breadcrumb m-0 bg-transparent p-0 text-sm">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Flash messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer d-flex justify-content-between align-items-center text-sm text-muted">
        <div>
            <strong>&copy; {{ date('Y') }} <a href="{{ route('landing') }}" class="text-dark">U.N.O (Use Not Own)</a></strong>. All rights reserved.
        </div>
        <div class="d-none d-sm-inline-block">
            Pusat Kendali Admin
        </div>
    </footer>
</div>

<!-- jQuery & Bootstrap 4 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<!-- AJAX & Turbo Helper Setup -->
<script>
    // Setup jQuery CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Global AJAX helper function for fast inline updates
    function updateResourceStatus(url, data, successCallback) {
        $.post(url, data)
            .done(function(res) {
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Status berhasil diperbarui'
                });
                if (typeof successCallback === 'function') {
                    successCallback(res);
                }
            })
            .fail(function(err) {
                let msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Terjadi kesalahan sistem';
                Toast.fire({
                    icon: 'error',
                    title: msg
                });
            });
    }

    function confirmDelete(formId, itemName) {
        Swal.fire({
            title: 'Hapus ' + (itemName || 'data') + '?',
            text: 'Data yang dihapus tidak dapat dipulihkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                }
            }
        });
    }

    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: {!! json_encode(session('success')) !!}
        });
    @endif
    @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: {!! json_encode(session('error')) !!}
        });
    @endif
</script>

@yield('scripts')
</body>
</html>

