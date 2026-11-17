<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $item->name }} | Sewa di U.N.O Rental Platform</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts -->
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
            --secondary: #6366f1;
            --accent: #f59e0b;
            --dark: #0f172a;
        }
        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Navbar */
        .uno-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
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

        /* Breadcrumb */
        .breadcrumb-wrap {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 12px 0;
            font-size: 0.88rem;
        }
        .breadcrumb-wrap a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }
        .breadcrumb-wrap a:hover {
            color: #0284c7;
        }
        .breadcrumb-wrap .current {
            color: #0f172a;
            font-weight: 600;
        }

        /* Gallery Tokopedia Style */
        .gallery-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            position: relative;
        }
        .gallery-main-wrap {
            position: relative;
            width: 100%;
            height: 440px;
            border-radius: 14px;
            overflow: hidden;
            background-color: #f1f5f9;
        }
        .gallery-main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .gallery-main-wrap:hover .gallery-main-img {
            transform: scale(1.03);
        }
        .gallery-thumb-item {
            width: 76px;
            height: 76px;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            background-color: #f1f5f9;
        }
        .gallery-thumb-item:hover, .gallery-thumb-item.active {
            border-color: #0284c7;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);
        }

        /* Product Detail Card */
        .pdp-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            margin-bottom: 24px;
        }
        .pdp-badge-condition {
            background: #ecfdf5;
            color: #059669;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            display: inline-block;
        }

        /* Tokopedia Tabs */
        .tokopedia-nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 24px;
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .tokopedia-nav-tabs::-webkit-scrollbar {
            display: none;
        }
        .tokopedia-nav-tabs .nav-item {
            white-space: nowrap;
            flex-shrink: 0;
        }
        .tokopedia-nav-tabs .nav-link {
            border: none;
            color: #64748b;
            font-weight: 600;
            padding: 10px 14px;
            position: relative;
            background: transparent;
            font-size: 0.88rem;
            white-space: nowrap;
        }
        .tokopedia-nav-tabs .nav-link.active {
            color: #0284c7;
            background: transparent;
        }
        .tokopedia-nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border-radius: 3px 3px 0 0;
        }

        /* Spec Table */
        .spec-item {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
        }
        .spec-label {
            width: 180px;
            color: #64748b;
            font-size: 0.9rem;
        }
        .spec-value {
            color: #0f172a;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Tokopedia Sticky Checkout Box */
        .sticky-tokopedia-card {
            position: sticky;
            top: 90px;
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }
        .price-breakdown-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 14px;
            padding: 16px;
        }

        /* Related Item Card */
        .related-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.25s ease;
            text-decoration: none !important;
            color: inherit;
            display: block;
            height: 100%;
        }
        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.08);
            border-color: #cbd5e1;
        }
        .related-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        /* Pagination & SVG Constraint */
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
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg uno-nav py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('landing') }}">
            <div class="brand-icon-box mr-2">
                <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
            </div>
            <div>
                <span class="font-weight-bold text-dark" style="font-size: 1.25rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                <span class="d-block text-muted text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.2px; font-weight: 700;">USE NOT OWN</span>
            </div>
        </a>

        <div class="ml-auto d-flex align-items-center">
            <a href="{{ route('catalog') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2 mr-2" style="border-radius: 10px;">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Katalog
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm font-weight-bold text-white px-3 py-2 shadow-sm mr-2" style="border-radius: 10px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                        <i class="fas fa-user-shield mr-1"></i> Admin Panel
                    </a>
                @endif
                <div class="dropdown mr-2">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center border px-3 py-1 shadow-sm" type="button" id="userMenuDropdownDetail" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 12px; background: #ffffff;">
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
                        <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-2" aria-labelledby="userMenuDropdownDetail" style="border-radius: 14px; min-width: 220px; z-index: 1060;">
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
</nav>

<!-- Breadcrumb -->
<div class="breadcrumb-wrap">
    <div class="container">
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('landing') }}"><i class="fas fa-home mr-1"></i> Beranda</a>
            <span class="mx-2 text-muted">/</span>
            <a href="{{ route('catalog') }}">Katalog Rental</a>
            <span class="mx-2 text-muted">/</span>
            <a href="{{ route('catalog', ['category' => $item->category_id]) }}">{{ $item->category->name }}</a>
            <span class="mx-2 text-muted">/</span>
            <span class="current text-truncate" style="max-width: 320px;">{{ $item->name }}</span>
        </div>
    </div>
</div>

<!-- Main Rental Page Container (Tokopedia Style) -->
<div class="container py-4">
    <div class="row">
        
        <!-- Left Column: Gallery & Details (Tokopedia Main Column) -->
        <div class="col-lg-8 col-md-7 mb-4">
            
            <!-- Gallery Card -->
            <div class="gallery-card mb-4">
                <div class="gallery-main-wrap mb-3">
                    <img id="mainGalleryImg" src="{{ $item->image_url }}" class="gallery-main-img" alt="{{ $item->name }}">
                    
                    <div style="position: absolute; top: 16px; left: 16px; display: flex; gap: 8px;">
                        @php
                            $condMap = [
                                'new' => 'Baru (New)',
                                'like_new' => 'Sangat Mulus (Like New)',
                                'good' => 'Bagus (Good)',
                                'fair' => 'Layak Pakai'
                            ];
                        @endphp
                        <span class="badge badge-dark px-3 py-2 shadow-sm" style="font-weight: 700; border-radius: 8px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(6px);">
                            {{ $condMap[$item->condition] ?? 'Normal' }}
                        </span>
                        <span class="badge badge-primary px-3 py-2 shadow-sm" style="font-weight: 700; border-radius: 8px; background: #0284c7;">
                            {{ $item->category->name }}
                        </span>
                    </div>

                    <div style="position: absolute; bottom: 16px; left: 16px;">
                        <span class="badge badge-light px-3 py-2 shadow-sm text-dark font-weight-bold" style="border-radius: 30px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);">
                            <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $item->location }}
                        </span>
                    </div>
                </div>

                <!-- Thumbnails Strip -->
                @if($item->images->count() > 0)
                <div class="d-flex flex-wrap gap-2 pt-1">
                    <img src="{{ $item->image_url }}" class="gallery-thumb-item mr-2 active" onclick="switchGalleryImg(this.src, this)" alt="Thumbnail Utama">
                    @foreach($item->images as $img)
                        @if($img->image_url !== $item->image_url)
                            <img src="{{ $img->image_url }}" class="gallery-thumb-item mr-2" onclick="switchGalleryImg(this.src, this)" alt="Thumbnail {{ $item->name }}">
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Header Info Card -->
            <div class="pdp-card">
                <div class="d-flex align-items-center mb-2">
                    <span class="pdp-badge-condition mr-2">
                        <i class="fas fa-shield-alt mr-1"></i> Kondisi: {{ $condMap[$item->condition] ?? 'Baik' }}
                    </span>
                    <span class="badge badge-light border text-muted">
                        Kode Unit: <b>#UNO-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</b>
                    </span>
                </div>

                <h1 class="h3 font-weight-bold text-dark mb-2" style="letter-spacing: -0.5px; line-height: 1.3;">
                    {{ $item->name }}
                </h1>

                <div class="d-flex align-items-center flex-wrap text-muted mb-3" style="font-size: 0.78rem; gap: 4px;">
                    <div class="text-warning mr-1">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= round($item->avg_rating) ? '' : 'text-muted' }}" style="font-size: 0.72rem;"></i>
                        @endfor
                    </div>
                    <strong class="text-dark">{{ number_format($item->avg_rating, 1) }}</strong>
                    <span>({{ $item->reviews_count }} Ulasan)</span>
                    <span class="text-muted">•</span>
                    <span style="white-space: nowrap;"><i class="fas fa-calendar-check text-primary mr-1"></i>Siap Disewa</span>
                    <span class="text-muted">•</span>
                    <span style="white-space: nowrap;"><i class="fas fa-map-marker-alt text-danger mr-1"></i>{{ $item->location }}</span>
                </div>

                <hr class="my-4">

                <!-- Tokopedia Style Navigation Tabs -->
                <ul class="nav tokopedia-nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-detail" role="tab">
                            <i class="fas fa-info-circle mr-1"></i> Detail & Spesifikasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-terms" role="tab">
                            <i class="fas fa-clipboard-list mr-1"></i> Syarat & Ketentuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-owner" role="tab">
                            <i class="fas fa-user-check mr-1"></i> Info Pemilik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-reviews" role="tab">
                            <i class="fas fa-comments mr-1"></i> Ulasan ({{ $item->reviews->count() }})
                        </a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content">
                    
                    <!-- Tab 1: Detail & Spesifikasi -->
                    <div class="tab-pane fade show active" id="tab-detail" role="tabpanel">
                        <h6 class="font-weight-bold text-dark mb-3">Spesifikasi Unit Rental</h6>
                        
                        <div class="spec-item">
                            <span class="spec-label">Kategori Barang</span>
                            <span class="spec-value text-primary">{{ $item->category->name }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Kondisi Fisik</span>
                            <span class="spec-value">{{ $condMap[$item->condition] ?? 'Normal' }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Lokasi Pengambilan</span>
                            <span class="spec-value">{{ $item->location }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Minimal Durasi Sewa</span>
                            <span class="spec-value">1 Hari Kalender (24 Jam)</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Status Unit</span>
                            <span class="spec-value text-success"><i class="fas fa-check-circle mr-1"></i> Tersedia & Siap Pakai</span>
                        </div>

                        <h6 class="font-weight-bold text-dark mt-4 mb-2">Deskripsi Lengkap</h6>
                        <div class="text-muted" style="line-height: 1.8; font-size: 0.95rem; white-space: pre-line;">
                            {{ $item->description }}
                        </div>

                        <div class="mt-4 p-3 bg-light rounded-lg border">
                            <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-box-check text-primary mr-2"></i> Standar Kelengkapan Unit U.N.O:</h6>
                            <ul class="mb-0 text-sm text-muted pl-3">
                                <li>Unit barang utama dalam kondisi bersih dan telah lolos uji fungsi.</li>
                                <li>Aksesoris orisinil lengkap (baterai, charger, kabel koneksi, atau pasak/tas pelindung).</li>
                                <li>Bimbingan singkat cara pemakaian unit saat serah terima.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab 2: Syarat & Ketentuan Sewa -->
                    <div class="tab-pane fade" id="tab-terms" role="tabpanel">
                        <h6 class="font-weight-bold text-dark mb-3">Prosedur & Ketentuan Sewa U.N.O</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100 bg-white">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary text-white rounded-circle p-2 mr-2 text-xs" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">1</div>
                                        <h6 class="font-weight-bold text-dark mb-0">Identitas Diri</h6>
                                    </div>
                                    <p class="text-muted text-sm mb-0">Penyewa wajib menunjukkan identitas asli (KTP/SIM/Paspor) yang masih berlaku pada saat serah terima unit barang.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100 bg-white">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary text-white rounded-circle p-2 mr-2 text-xs" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">2</div>
                                        <h6 class="font-weight-bold text-dark mb-0">Serah Terima & Cek Fisik</h6>
                                    </div>
                                    <p class="text-muted text-sm mb-0">Penyewa dan pemilik akan melakukan inspeksi bersama sebelum unit dibawa untuk memastikan seluruh fungsi berjalan 100% prima.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100 bg-white">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary text-white rounded-circle p-2 mr-2 text-xs" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">3</div>
                                        <h6 class="font-weight-bold text-dark mb-0">Metode Pengambilan</h6>
                                    </div>
                                    <p class="text-muted text-sm mb-0">Bisa diambil langsung ke lokasi pemilik di <b>{{ $item->location }}</b> atau dikirim menggunakan jasa kurir instan (Grab/Gojek).</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100 bg-white">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary text-white rounded-circle p-2 mr-2 text-xs" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">4</div>
                                        <h6 class="font-weight-bold text-dark mb-0">Pengembalian Tepat Waktu</h6>
                                    </div>
                                    <p class="text-muted text-sm mb-0">Unit dikembalikan pada tanggal selesai yang disepakati dengan kelengkapan awal tanpa kerusakan fisik baru.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Info Pemilik / Mitra -->
                    <div class="tab-pane fade" id="tab-owner" role="tabpanel">
                        <div class="d-flex align-items-center border rounded-lg p-3 bg-white mb-3">
                            <img src="{{ $item->owner->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode($item->owner->name).'&background=0284c7&color=fff' }}" 
                                 class="rounded-circle mr-3 shadow-sm" style="width: 65px; height: 65px; object-fit: cover;" alt="{{ $item->owner->name }}">
                            <div>
                                <h5 class="font-weight-bold text-dark mb-1">{{ $item->owner->name }}</h5>
                                <div class="text-sm text-muted mb-1">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $item->location }}
                                    <span class="badge badge-success ml-2 px-2 py-1"><i class="fas fa-check mr-1"></i> Mitra Terverifikasi</span>
                                </div>
                                <div class="text-xs text-muted">
                                    Bergabung sejak {{ $item->owner->created_at ? $item->owner->created_at->format('M Y') : '2024' }} • Respon Cepat & Ramah
                                </div>
                            </div>
                        </div>
                        <p class="text-muted text-sm">
                            Pemilik barang rental ini berkomitmen menjaga kebersihan, fungsi, dan kelengkapan unit sebelum disewakan kepada Anda.
                        </p>
                    </div>

                    <!-- Tab 4: Ulasan Penyewa -->
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                        <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-lg border">
                            <div class="text-center mr-4 pr-4 border-right">
                                <h1 class="font-weight-bold text-primary mb-0" style="font-size: 2.8rem;">
                                    {{ number_format($item->avg_rating, 1) }}
                                </h1>
                                <div class="text-warning text-sm">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fas fa-star {{ $i <= round($item->avg_rating) ? '' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <small class="text-muted">{{ $item->reviews->count() }} Penilaian</small>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark mb-1">Kepuasan Penyewa U.N.O</h6>
                                <p class="text-muted text-sm mb-0">Seluruh ulasan berasal dari penyewa terverifikasi yang telah menyelesaikan masa sewa unit ini.</p>
                            </div>
                        </div>

                        @forelse($item->reviews as $rev)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle mr-2 d-flex align-items-center justify-content-center font-weight-bold text-xs" style="width: 32px; height: 32px;">
                                        {{ substr($rev->user->name, 0, 1) }}
                                    </div>
                                    <strong class="text-dark">{{ $rev->user->name }}</strong>
                                </div>
                                <div class="text-warning text-xs">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted text-sm mb-1 pl-4 ml-2">"{{ $rev->comment }}"</p>
                            <small class="text-muted text-xs pl-4 ml-2"><i class="fas fa-clock mr-1"></i> Disewa pada {{ $rev->created_at->format('d M Y') }}</small>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-comment-alt-smile fa-2x mb-2 text-muted"></i>
                            <p class="mb-0">Belum ada review tertulis untuk unit ini. Jadilah penyewa pertama!</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>

        <!-- Right Column: Tokopedia Sticky Rent & Checkout Box -->
        <div class="col-lg-4 col-md-5">
            <div class="sticky-tokopedia-card">
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase text-xs font-weight-bold text-muted" style="letter-spacing: 0.8px;">Atur Periode Sewa</span>
                    <span class="badge badge-success px-2 py-1 font-weight-semibold">
                        <i class="fas fa-check-circle mr-1"></i> Siap Sewa
                    </span>
                </div>

                <!-- Price Tag -->
                <div class="d-flex align-items-baseline mb-3">
                    <h2 class="font-weight-bold text-primary mb-0" style="letter-spacing: -0.5px;">
                        Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                    </h2>
                    <span class="text-muted ml-2 font-weight-medium" style="font-size: 0.95rem;">/ hari</span>
                </div>

                <hr class="my-3">

                <!-- Booking Form -->
                <form id="formRentBooking" action="{{ route('book.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <div class="form-group mb-3">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                            <i class="fas fa-calendar-alt text-primary mr-1"></i> Tanggal Mulai Sewa <span class="text-danger">*</span>
                        </label>
                        <input type="date" id="rentStartDate" name="start_date" 
                               class="form-control font-weight-semibold" 
                               min="{{ date('Y-m-d') }}" 
                               value="{{ date('Y-m-d') }}" 
                               onchange="calculateRentalTotal()" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                            <i class="fas fa-calendar-check text-primary mr-1"></i> Tanggal Selesai Sewa <span class="text-danger">*</span>
                        </label>
                        <input type="date" id="rentEndDate" name="end_date" 
                               class="form-control font-weight-semibold" 
                               min="{{ date('Y-m-d') }}" 
                               value="{{ date('Y-m-d', strtotime('+2 days')) }}" 
                               onchange="calculateRentalTotal()" required>
                    </div>

                    <!-- Live Duration Badge -->
                    <div class="badge badge-light border text-primary font-weight-bold py-2 w-100 text-center mb-3" style="font-size: 0.88rem; border-radius: 8px;">
                        <i class="fas fa-clock mr-1"></i> Total Durasi: <span id="durDays">3</span> Hari Sewa
                    </div>

                    @auth
                    <div class="p-3 mb-3 bg-light rounded border">
                        <div class="d-flex align-items-start">
                            <img src="{{ Auth::user()->profile_photo ? (str_starts_with(Auth::user()->profile_photo, 'http') ? Auth::user()->profile_photo : asset('storage/'.Auth::user()->profile_photo)) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0284c7&color=fff' }}" 
                                 class="rounded-circle mr-3 flex-shrink-0" style="width: 44px; height: 44px; object-fit: cover; border: 2px solid #e2e8f0;" alt="{{ Auth::user()->name }}">
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="text-xs text-muted mb-1">Menyewa sebagai:</div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                                    <span class="font-weight-bold text-dark" style="font-size: 0.92rem; line-height: 1.3;">{{ Auth::user()->name }}</span>
                                    <span class="badge badge-success d-inline-flex align-items-center" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px; white-space: nowrap;">
                                        <i class="fas fa-check-circle mr-1" style="font-size: 0.6rem;"></i> Terverifikasi
                                    </span>
                                </div>
                                @if(Auth::user()->phone)
                                <div class="text-xs text-muted mt-2">
                                    <i class="fab fa-whatsapp text-success mr-1"></i> WhatsApp: <span class="font-weight-semibold text-dark">{{ Auth::user()->phone }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="renter_name" value="{{ Auth::user()->name }}">
                        @if(Auth::user()->phone)
                            <input type="hidden" name="renter_phone" value="{{ Auth::user()->phone }}">
                        @else
                            <div class="form-group mb-0 mt-3">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    No. WhatsApp Aktif <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="renter_phone" class="form-control form-control-sm" placeholder="Contoh: 08123456789" required>
                                <small class="text-muted text-xs">Diperlukan untuk konfirmasi serah terima unit.</small>
                            </div>
                        @endif
                    </div>
                    @else
                    <div class="form-group mb-3">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                            Nama Lengkap Penyewa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="renter_name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                            No. WhatsApp Aktif <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="renter_phone" class="form-control" placeholder="Contoh: 08123456789" required>
                        <small class="text-muted text-xs">Untuk konfirmasi serah terima & kontak pemilik.</small>
                    </div>
                    @endauth

                    <div class="form-group mb-3">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                            Catatan / Keperluan Sewa
                        </label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Disewa untuk syuting dokumentasi di Surabaya..."></textarea>
                    </div>

                    <!-- Price Breakdown Box (Tokopedia Summary) -->
                    <div class="price-breakdown-box mb-4">
                        <table class="w-100" style="font-size: 0.85rem;">
                            <tr>
                                <td class="text-muted py-1" style="white-space: nowrap;">Tarif Sewa Harian:</td>
                                <td class="text-dark font-weight-medium text-right py-1">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Durasi Sewa:</td>
                                <td class="text-dark font-weight-medium text-right py-1" style="white-space: nowrap;"><span id="durDaysCalc">3</span> Hari x Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1" style="white-space: nowrap;">Biaya Layanan Platform:</td>
                                <td class="text-success font-weight-bold text-right py-1">GRATIS</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1" style="white-space: nowrap;">Proteksi Unit:</td>
                                <td class="text-success font-weight-bold text-right py-1">Termasuk</td>
                            </tr>
                        </table>
                        
                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold text-dark" style="font-size: 0.95rem; white-space: nowrap;">TOTAL BIAYA:</span>
                            <h3 class="font-weight-bold text-primary mb-0" id="totalPrice" style="font-size: 1.35rem; white-space: nowrap;">
                                Rp {{ number_format($item->price_per_day * 3, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <button type="submit" id="btnSubmitBooking" class="btn btn-primary btn-block btn-lg font-weight-bold py-3 mb-2 shadow-sm text-white" 
                            style="border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none; font-size: 1.05rem;">
                        <i class="fas fa-check-circle mr-1"></i> Ajukan Sewa Sekarang
                    </button>

                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $item->owner->phone ?? '081298765432');
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($item->owner->name) }},%20saya%20tertarik%20menyewa%20{{ urlencode($item->name) }}%20melalui%20platform%20UNO." 
                       target="_blank" 
                       class="btn btn-outline-success btn-block font-weight-bold py-2 mb-3" 
                       style="border-radius: 10px;">
                        <i class="fab fa-whatsapp mr-1"></i> Chat Pemilik Unit
                    </a>
                </form>

                <!-- Trust Guarantee List -->
                <div class="pt-2 border-top" style="font-size: 0.75rem; color: #64748b;">
                    <div class="mb-1" style="white-space: nowrap;"><i class="fas fa-check-circle text-success mr-1"></i> Jaminan Unit 100% Berfungsi Normal</div>
                    <div class="mb-1" style="white-space: nowrap;"><i class="fas fa-bolt text-warning mr-1"></i> Konfirmasi Booking Instan & Cepat</div>
                    <div style="white-space: nowrap;"><i class="fas fa-shield-alt text-primary mr-1"></i> Transaksi Aman Tanpa Deposit</div>
                </div>

            </div>
        </div>

    </div>

    <!-- Related Items (Tokopedia Style Rekomendasi Unit) -->
    @if(isset($relatedItems) && $relatedItems->count() > 0)
    <div class="mt-5 pt-3 border-top">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold text-dark mb-1">Rekomendasi Unit Rental Lainnya</h4>
                <p class="text-muted text-sm mb-0">Pilihan unit sewa terkait di kategori {{ $item->category->name }}</p>
            </div>
            <a href="{{ route('catalog', ['category' => $item->category_id]) }}" class="btn btn-outline-primary btn-sm font-weight-bold" style="border-radius: 8px;">
                Lihat Semua <i class="fas fa-chevron-right text-xs ml-1"></i>
            </a>
        </div>

        <div class="row">
            @foreach($relatedItems as $rel)
            <div class="col-lg-4 col-md-6 mb-3">
                <a href="{{ route('items.show', $rel->id) }}" class="related-card">
                    <img src="{{ $rel->image_url }}" class="related-img" alt="{{ $rel->name }}">
                    <div class="p-3">
                        <span class="badge badge-light border text-muted mb-1 text-xs">
                            <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $rel->location }}
                        </span>
                        <h6 class="font-weight-bold text-dark mb-2 text-truncate" title="{{ $rel->name }}">{{ $rel->name }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-primary font-weight-bold text-nowrap">
                                Rp {{ number_format($rel->price_per_day, 0, ',', '.') }}<small class="text-muted">/hari</small>
                            </div>
                            <span class="btn btn-xs btn-outline-primary font-weight-bold">Sewa <i class="fas fa-arrow-right text-xs"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

<!-- Footer -->
<footer class="bg-white border-top py-4 mt-5 text-center text-sm text-muted">
    <div class="container">
        <p class="mb-1"><strong>&copy; {{ date('Y') }} U.N.O (Use Not Own).</strong> Platform E-Commerce Rental Terpercaya.</p>
        <p class="mb-0 text-xs">Node Server: <code>10.61.4.129</code> • Aman, Cepat, dan Praktis.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const dailyRate = {{ (int) $item->price_per_day }};

    function switchGalleryImg(newSrc, elem) {
        document.getElementById('mainGalleryImg').src = newSrc;
        $('.gallery-thumb-item').removeClass('active');
        $(elem).addClass('active');
    }

    function calculateRentalTotal() {
        const startVal = document.getElementById('rentStartDate').value;
        const endVal = document.getElementById('rentEndDate').value;

        if (!startVal || !endVal) return;

        const start = new Date(startVal);
        const end = new Date(endVal);

        let diffTime = end - start;
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        if (diffDays < 1) diffDays = 1;

        const totalPrice = diffDays * dailyRate;

        document.getElementById('durDays').innerText = diffDays;
        document.getElementById('durDaysCalc').innerText = diffDays;
        document.getElementById('totalPrice').innerText = 'Rp ' + Number(totalPrice).toLocaleString('id-ID');
    }

    // Initialize calculation on load
    $(document).ready(function() {
        calculateRentalTotal();

        // AJAX Booking Form Submission
        $('#formRentBooking').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#btnSubmitBooking');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses Sewa...');

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('book.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fas fa-check-circle mr-1"></i> Ajukan Sewa Sekarang');

                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Sewa Berhasil Diajukan!',
                        html: `
                            <div class="text-left p-3 bg-light rounded border my-2 text-sm">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Nomor Pesanan:</span>
                                    <span class="font-weight-bold text-primary">#BK-${res.booking_id}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Unit Barang:</span>
                                    <span class="font-weight-bold text-dark">{{ addslashes($item->name) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Durasi Sewa:</span>
                                    <span class="font-weight-bold text-dark">${res.total_days} Hari</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Total Biaya:</span>
                                    <span class="font-weight-bold text-success" style="font-size: 1.1rem;">Rp ${Number(res.total_price).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                            <p class="text-muted text-sm mb-0">Pesanan telah dicatat oleh sistem. Pemilik unit <b>{{ addslashes($item->owner->name) }}</b> dan admin kami akan segera menghubungi Anda untuk koordinasi serah terima.</p>
                        `,
                        showCancelButton: true,
                        confirmButtonText: '<i class="fab fa-whatsapp mr-1"></i> Chat WhatsApp Pemilik',
                        cancelButtonText: '<i class="fas fa-th-large mr-1"></i> Lihat Katalog Lainnya',
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#0284c7'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open("https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($item->owner->name) }},%20saya%20sudah%20mengajukan%20booking%20sewa%20untuk%20{{ urlencode($item->name) }}%20dengan%20nomor%20pesanan%20%23BK-" + res.booking_id + ".", "_blank");
                        } else {
                            window.location.href = "{{ route('catalog') }}";
                        }
                    });
                },
                error: function(err) {
                    btn.prop('disabled', false).html('<i class="fas fa-check-circle mr-1"></i> Ajukan Sewa Sekarang');
                    let msg = 'Terjadi kesalahan saat memproses booking sewa.';
                    if (err.responseJSON) {
                        if (err.responseJSON.errors) {
                            let errList = Object.values(err.responseJSON.errors).flat();
                            msg = errList.join('<br>');
                        } else if (err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengajukan Sewa',
                        html: msg,
                        confirmButtonColor: '#0284c7'
                    });
                }
            });
        });
    });
</script>
</body>
</html>
