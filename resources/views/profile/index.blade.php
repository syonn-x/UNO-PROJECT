<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Akun & Profil Saya | U.N.O Rental Platform</title>
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
            --primary-light: #e0f2fe;
            --tokopedia-green: #03ac0e;
            --tokopedia-green-light: #ebfbee;
            --dark: #0f172a;
        }

        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f6f9;
            color: #1e293b;
        }

        /* Navbar */
        .uno-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1040;
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

        /* Tokopedia 2-Column Profile Layout */
        .profile-sidebar-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .user-header-box {
            padding: 24px 20px 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }

        .user-avatar-wrap {
            position: relative;
            width: 86px;
            height: 86px;
            margin: 0 auto 12px auto;
        }

        .user-avatar-img {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        /* Sidebar Nav Links */
        .profile-nav-group-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.8px;
            color: #94a3b8;
            padding: 16px 20px 6px 20px;
            margin: 0;
        }

        .profile-nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 20px;
            color: #475569;
            font-size: 0.88rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .profile-nav-item:hover {
            background-color: #f8fafc;
            color: var(--primary);
            text-decoration: none;
        }

        .profile-nav-item.active {
            background-color: #f0f9ff;
            color: var(--primary);
            font-weight: 700;
            border-left-color: var(--primary);
        }

        .profile-nav-item i {
            width: 22px;
            text-align: center;
            margin-right: 10px;
            font-size: 1rem;
        }

        /* Main Content Box */
        .profile-content-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 28px;
            margin-bottom: 24px;
        }

        .content-card-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .content-card-subtitle {
            font-size: 0.86rem;
            color: #64748b;
            margin-bottom: 20px;
        }

        /* Status Filter Chips */
        .status-chip {
            padding: 6px 16px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-right: 6px;
            margin-bottom: 8px;
            transition: all 0.15s ease;
        }

        .status-chip:hover {
            border-color: #cbd5e1;
            color: var(--primary);
            text-decoration: none;
        }

        .status-chip.active {
            background: #f0f9ff;
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Tokopedia Order / Rental Card */
        .rental-order-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            margin-bottom: 16px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .rental-order-card:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
            border-color: #cbd5e1;
        }

        .rental-card-header {
            padding: 12px 20px;
            background-color: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .rental-card-body {
            padding: 18px 20px;
        }

        .rental-item-thumb {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        /* Badges */
        .badge-pending { background-color: #fef3c7; color: #b45309; }
        .badge-confirmed { background-color: #e0f2fe; color: #0369a1; }
        .badge-completed { background-color: #dcfce7; color: #15803d; }
        .badge-cancelled { background-color: #fee2e2; color: #b91c1c; }

        /* Stats Card (Owner) */
        .stat-banner-card {
            border-radius: 14px;
            padding: 18px 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: transform 0.2s;
        }
        .stat-banner-card:hover {
            transform: translateY(-2px);
        }

        /* Star Rating in Modal */
        .rating-stars {
            display: inline-flex;
            flex-direction: row-reverse;
            font-size: 2rem;
            color: #cbd5e1;
            cursor: pointer;
        }
        .rating-stars input {
            display: none;
        }
        .rating-stars label {
            margin: 0 4px;
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-stars label:hover,
        .rating-stars label:hover ~ label,
        .rating-stars input:checked ~ label {
            color: #f59e0b;
        }
    </style>
</head>
<body>

<!-- Top Navbar (Tokopedia Style) -->
<nav class="uno-nav py-2">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="d-flex align-items-center text-decoration-none">
                <div class="brand-icon-box mr-2">
                    <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
                </div>
                <div>
                    <span class="font-weight-bold text-dark" style="font-size: 1.25rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                    <span class="d-block text-muted text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.2px; font-weight: 700;">USE NOT OWN</span>
                </div>
            </a>

            <!-- Quick Navigation -->
            <div class="d-flex align-items-center">
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary btn-sm font-weight-bold mr-3 px-3 py-2" style="border-radius: 10px;">
                    <i class="fas fa-th-large mr-1"></i> Katalog Sewa
                </a>
                <a href="{{ route('landing') }}" class="btn btn-light btn-sm font-weight-semibold mr-3 px-3 py-2 text-dark border d-none d-md-inline-block" style="border-radius: 10px;">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center border px-3 py-1 shadow-sm" type="button" id="userMenuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 12px; background: #ffffff;">
                        <img src="{{ $user->avatar_url }}" 
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0284c7&color=fff';"
                             class="rounded-circle mr-2" style="width: 28px; height: 28px; object-fit: cover;" alt="{{ $user->name }}">
                        <div class="text-left mr-1">
                            <div class="font-weight-bold text-dark text-xs" style="line-height: 1.1;">{{ Str::limit($user->name, 14) }}</div>
                            <span class="badge {{ $user->isOwner() ? 'badge-warning text-dark' : 'badge-primary text-white' }}" style="font-size: 0.62rem; padding: 1px 5px;">
                                {{ $user->isOwner() ? 'Mitra Owner' : 'Penyewa' }}
                            </span>
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-2" aria-labelledby="userMenuDropdown" style="border-radius: 14px; min-width: 220px;">
                        <div class="px-3 py-2 border-bottom mb-2 bg-light rounded">
                            <div class="font-weight-bold text-dark text-sm">{{ $user->name }}</div>
                            <div class="text-muted text-xs text-truncate">{{ $user->email }}</div>
                            <span class="badge badge-success text-xs mt-1"><i class="fas fa-check-circle mr-1"></i> {{ $user->role_label }}</span>
                        </div>
                        <a class="dropdown-item py-2 rounded font-weight-medium {{ $tab == 'profile' ? 'active text-primary' : '' }}" href="{{ route('profile.index', ['tab' => 'profile']) }}">
                            <i class="fas fa-user-circle text-primary mr-2"></i> Biodata Diri
                        </a>
                        <a class="dropdown-item py-2 rounded font-weight-medium {{ $tab == 'rentals' ? 'active text-success' : '' }}" href="{{ route('profile.index', ['tab' => 'rentals']) }}">
                            <i class="fas fa-box text-success mr-2"></i> Riwayat Sewa Saya
                        </a>
                        <a class="dropdown-item py-2 rounded font-weight-medium {{ $tab == 'favorites' ? 'active text-danger' : '' }}" href="{{ route('profile.index', ['tab' => 'favorites']) }}">
                            <i class="fas fa-heart text-danger mr-2"></i> Wishlist Favorit
                        </a>
                        @if($user->isOwner())
                            <div class="dropdown-divider my-2"></div>
                            <h6 class="dropdown-header text-xs text-uppercase font-weight-bold text-muted px-3">Menu Mitra Rental</h6>
                            <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'my-items']) }}">
                                <i class="fas fa-store text-warning mr-2"></i> Unit Rental Saya
                            </a>
                            <a class="dropdown-item py-2 rounded font-weight-medium" href="{{ route('profile.index', ['tab' => 'incoming-bookings']) }}">
                                <i class="fas fa-bell text-info mr-2"></i> Pesanan Sewa Masuk
                            </a>
                        @endif
                        @if($user->isAdmin())
                            <div class="dropdown-divider my-2"></div>
                            <a class="dropdown-item py-2 rounded font-weight-bold text-primary" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-user-shield mr-2"></i> Admin Panel
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

            </div>
        </div>
    </div>
</nav>

<!-- Main Container (Tokopedia 2-Column Account) -->
<div class="container py-4">

    <!-- Flash message alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-lg shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-lg shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Perhatian:</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        
        <!-- LEFT COLUMN: Tokopedia User Sidebar Navigation -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="profile-sidebar-card">
                
                <!-- User Header Box -->
                <div class="user-header-box">
                    <div class="user-avatar-wrap">
                        <img src="{{ $user->avatar_url }}" 
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0284c7&color=fff';"
                             class="user-avatar-img" alt="{{ $user->name }}">
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1" style="font-size: 1.05rem;">{{ $user->name }}</h5>
                    <div class="mb-2">
                        <span class="badge {{ $user->isOwner() ? 'badge-warning text-dark font-weight-bold' : 'badge-primary' }} px-2 py-1" style="font-size: 0.72rem;">
                            <i class="{{ $user->isOwner() ? 'fas fa-store mr-1' : 'fas fa-shopping-bag mr-1' }}"></i>
                            {{ $user->role_label }}
                        </span>
                        @if($user->isOwner() && $user->store_name)
                            <div class="mt-1">
                                <span class="badge badge-light border text-muted px-2 py-1" style="font-size: 0.72rem;">
                                    <i class="fas fa-check-circle text-success mr-1"></i> {{ $user->store_name }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="text-xs text-muted">
                        <i class="far fa-calendar-alt mr-1"></i> Bergabung {{ $user->created_at ? $user->created_at->format('M Y') : '2024' }}
                    </div>
                </div>

                <!-- Nav Menu List -->
                <div class="py-2">
                    <div class="profile-nav-group-title">Akun Saya</div>
                    <a href="{{ route('profile.index', ['tab' => 'profile']) }}" class="profile-nav-item {{ $tab == 'profile' ? 'active' : '' }}">
                        <div><i class="fas fa-user-circle text-primary"></i> Biodata Diri</div>
                        <i class="fas fa-chevron-right text-xs text-muted"></i>
                    </a>

                    <div class="profile-nav-group-title">Aktivitas Sewa</div>
                    <a href="{{ route('profile.index', ['tab' => 'rentals']) }}" class="profile-nav-item {{ $tab == 'rentals' ? 'active' : '' }}">
                        <div><i class="fas fa-box text-success"></i> Riwayat Sewa Saya</div>
                        @if($pendingRentalsCount > 0)
                            <span class="badge badge-warning text-xs">{{ $pendingRentalsCount }}</span>
                        @else
                            <i class="fas fa-chevron-right text-xs text-muted"></i>
                        @endif
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'favorites']) }}" class="profile-nav-item {{ $tab == 'favorites' ? 'active' : '' }}">
                        <div><i class="fas fa-heart text-danger"></i> Wishlist Favorit</div>
                        <span class="badge badge-light border text-xs">{{ $favorites->count() }}</span>
                    </a>

                    <div class="profile-nav-group-title" style="color: #ef4444;">Bantuan & Keamanan</div>
                    <a href="{{ route('profile.index', ['tab' => 'fraud-messages']) }}" class="profile-nav-item {{ $tab == 'fraud-messages' ? 'active' : '' }}">
                        <div><i class="fas fa-shield-alt text-danger"></i> Aduan Penipuan</div>
                        @if(isset($pendingFraudCount) && $pendingFraudCount > 0)
                            <span class="badge badge-danger text-xs font-weight-bold">{{ $pendingFraudCount }} Kasus</span>
                        @else
                            <i class="fas fa-chevron-right text-xs text-muted"></i>
                        @endif
                    </a>

                    @if($user->isOwner())
                        <!-- Special Mitra Rental Menu (Owner) -->
                        <div class="profile-nav-group-title" style="color: #d97706;">Mitra Rental (Owner)</div>
                        <a href="{{ route('profile.index', ['tab' => 'my-items']) }}" class="profile-nav-item {{ $tab == 'my-items' ? 'active' : '' }}">
                            <div><i class="fas fa-store text-warning"></i> Unit Rental Saya</div>
                            <span class="badge badge-light border text-xs">{{ $myItems->count() }}</span>
                        </a>
                        <a href="{{ route('profile.index', ['tab' => 'incoming-bookings']) }}" class="profile-nav-item {{ $tab == 'incoming-bookings' ? 'active' : '' }}">
                            <div><i class="fas fa-bell text-info"></i> Pesanan Masuk</div>
                            @if($pendingIncomingCount > 0)
                                <span class="badge badge-danger text-xs font-weight-bold">{{ $pendingIncomingCount }} Baru</span>
                            @else
                                <i class="fas fa-chevron-right text-xs text-muted"></i>
                            @endif
                        </a>
                        <a href="{{ route('profile.index', ['tab' => 'add-item']) }}" class="profile-nav-item {{ $tab == 'add-item' ? 'active' : '' }}">
                            <div><i class="fas fa-plus-circle text-success"></i> Tambah Unit Baru</div>
                            <i class="fas fa-chevron-right text-xs text-muted"></i>
                        </a>
                    @else
                        <!-- Upgrade to Owner CTA Card for Renter -->
                        <div class="p-3 m-3 rounded-lg border bg-light text-center">
                            <i class="fas fa-store fa-2x text-warning mb-2"></i>
                            <div class="font-weight-bold text-dark text-xs mb-1">Punya Barang Menganggur?</div>
                            <p class="text-muted text-xs mb-2">Dapatkan cuan tambahan dengan menyewakan kamera, tenda, atau gadget Anda di UNO.</p>
                            <a href="{{ route('profile.become-owner') }}" class="btn btn-warning btn-block btn-sm font-weight-bold text-dark shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-id-card-alt mr-1"></i> Buka Mitra Rental
                            </a>
                            <small class="d-block text-muted text-xs mt-2" style="font-size: 0.68rem;">
                                <i class="fas fa-shield-alt text-success mr-1"></i> 3 Langkah Verifikasi Aman
                            </small>
                        </div>
                    @endif

                    <div class="border-top my-2 pt-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="profile-nav-item text-danger border-0 bg-transparent w-100 text-left font-weight-medium">
                                <div><i class="fas fa-sign-out-alt"></i> Keluar dari Akun</div>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Tab Content Display -->
        <div class="col-lg-9 col-md-8">

            <!-- TAB 1: BIODATA DIRI & PROFIL -->
            @if($tab == 'profile')
            <div class="profile-content-card">
                <div class="content-card-title">Biodata Diri & Akun</div>
                <div class="content-card-subtitle">Kelola informasi identitas akun Anda untuk kemudahan transaksi sewa barang.</div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Sub-column: Form Data -->
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    Alamat Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                <small class="text-muted text-xs">Email digunakan untuk notifikasi konfirmasi booking sewa.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    Nomor WhatsApp Aktif <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                                <small class="text-muted text-xs">Nomor ini digunakan pemilik unit & kurir untuk koordinasi serah terima barang.</small>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    Peran Akun Saat Ini
                                </label>
                                <div class="p-3 bg-light rounded border d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $user->role_label }}</div>
                                        <div class="text-muted text-xs">
                                            @if($user->isOwner())
                                                Anda dapat menyewakan unit barang Anda sekaligus menyewa dari mitra lain.
                                            @else
                                                Anda terdaftar sebagai penyewa aktif di platform UNO Rental.
                                            @endif
                                        </div>
                                    </div>
                                    @if(!$user->isOwner())
                                        <button type="submit" formaction="{{ route('profile.upgrade-owner') }}" formmethod="POST" class="btn btn-outline-warning btn-sm font-weight-bold">
                                            Aktifkan Mitra Owner
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Password update section -->
                            <h6 class="font-weight-bold text-dark mb-2">Ubah Kata Sandi (Opsional)</h6>
                            <p class="text-muted text-xs mb-3">Kosongkan jika Anda tidak ingin mengubah kata sandi.</p>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">Kata Sandi Baru</label>
                                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">Konfirmasi Kata Sandi</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan Profil
                                </button>
                            </div>
                        </div>

                        <!-- Right Sub-column: Foto Profil Box -->
                        <div class="col-md-4 text-center border-left pl-md-4">
                            <label class="font-weight-semibold text-xs text-muted text-uppercase mb-2 d-block">Foto Profil</label>
                            <img src="{{ $user->avatar_url }}" 
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0284c7&color=fff';"
                                 class="rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e2e8f0;">
                            
                            <div class="form-group mb-2">
                                <label class="btn btn-outline-primary btn-sm btn-block font-weight-bold" style="border-radius: 8px; cursor: pointer;">
                                    <i class="fas fa-camera mr-1"></i> Pilih Foto Baru
                                    <input type="file" name="profile_photo_file" accept="image/*" class="d-none" onchange="previewAvatar(this)">
                                </label>
                                <small class="text-muted text-xs d-block">Maksimal 2MB (JPG, PNG, WebP).</small>
                            </div>

                            <div class="mt-3 text-left">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">Atau Gunakan URL Gambar</label>
                                <input type="url" name="profile_photo_url" class="form-control form-control-sm" placeholder="https://..." value="{{ str_starts_with($user->profile_photo ?? '', 'http') ? $user->profile_photo : '' }}">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- TAB 2: RIWAYAT TRANSAKSI SEWA (RENTER) -->
            @elseif($tab == 'rentals')
            <div class="profile-content-card">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                    <div>
                        <div class="content-card-title">Riwayat Transaksi Sewa Saya</div>
                        <div class="content-card-subtitle mb-0">Daftar seluruh pesanan rental barang yang Anda ajukan di platform U.N.O.</div>
                    </div>
                    <a href="{{ route('catalog') }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2 my-1" style="border-radius: 10px;">
                        <i class="fas fa-plus mr-1"></i> Sewa Barang Baru
                    </a>
                </div>

                <!-- Panduan Alur Komunikasi & Pengaduan Sewa -->
                <div class="alert alert-light border rounded-lg p-3 my-3 shadow-sm" style="background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 100%); border-left: 4px solid #10b981 !important;">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-headset fa-2x text-success mr-3 mt-1"></i>
                        <div class="text-xs" style="line-height: 1.6;">
                            <div class="font-weight-bold text-dark text-sm mb-1">Panduan Pengaduan & Komunikasi Transaksi Sewa:</div>
                            <div>
                                <span class="badge badge-success px-2 py-1 mr-1"><i class="fab fa-whatsapp mr-1"></i> Keluhan Kecil & Tanya Barang:</span>
                                Langsung klik <strong>"Chat Pemilik (WhatsApp)"</strong> pada kartu pesanan. Tanya stok, kondisi barang, janjian COD, atau jika terlambat mengembalikan barang diselesaikan langsung dengan pemilik toko.
                            </div>
                            <div class="mt-1">
                                <span class="badge badge-danger px-2 py-1 mr-1"><i class="fas fa-exclamation-triangle mr-1"></i> Kena Tipu?</span>
                                Jika uang sudah Anda transfer namun <strong>pemilik kabur / memblokir nomor Anda / barang fiktif</strong>, segera klik tombol merah <strong>"Laporkan Penipuan (Ketipu)"</strong>. Pesan Anda akan langsung masuk ke Tim Keamanan Admin Pusat untuk membekukan akun pelaku.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tokopedia Style Status Filter Chips -->
                <div class="my-3 pb-2 border-bottom d-flex flex-wrap align-items-center">
                    <span class="text-xs text-muted font-weight-bold mr-2 text-uppercase">Status:</span>
                    <a href="{{ route('profile.index', ['tab' => 'rentals']) }}" class="status-chip {{ !request('status') ? 'active' : '' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'rentals', 'status' => 'pending']) }}" class="status-chip {{ request('status') == 'pending' ? 'active' : '' }}">
                        <i class="fas fa-hourglass-half text-warning mr-1"></i> Menunggu Konfirmasi
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'rentals', 'status' => 'confirmed']) }}" class="status-chip {{ request('status') == 'confirmed' ? 'active' : '' }}">
                        <i class="fas fa-check-circle text-primary mr-1"></i> Disetujui & Aktif
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'rentals', 'status' => 'completed']) }}" class="status-chip {{ request('status') == 'completed' ? 'active' : '' }}">
                        <i class="fas fa-flag-checkered text-success mr-1"></i> Selesai
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'rentals', 'status' => 'cancelled']) }}" class="status-chip {{ request('status') == 'cancelled' ? 'active' : '' }}">
                        <i class="fas fa-times-circle text-danger mr-1"></i> Dibatalkan
                    </a>
                </div>

                <!-- Rental Bookings Cards List -->
                @forelse($rentals as $b)
                <div class="rental-order-card">
                    <div class="rental-card-header">
                        <div class="d-flex align-items-center text-xs">
                            <span class="font-weight-bold text-dark mr-2"><i class="fas fa-shopping-bag text-primary mr-1"></i> Sewa Barang</span>
                            <span class="text-muted mr-2">•</span>
                            <span class="text-muted mr-2">{{ $b->created_at ? $b->created_at->format('d M Y, H:i') : '-' }}</span>
                            <span class="text-muted mr-2">•</span>
                            <span class="font-weight-semibold text-primary">#BK-{{ $b->id }}</span>
                        </div>
                        <div>
                            @php
                                $statusLabels = [
                                    'pending' => ['badge' => 'badge-pending', 'label' => 'Menunggu Konfirmasi Pemilik'],
                                    'confirmed' => ['badge' => 'badge-confirmed', 'label' => 'Disetujui / Sedang Disewa'],
                                    'completed' => ['badge' => 'badge-completed', 'label' => 'Sewa Selesai'],
                                    'cancelled' => ['badge' => 'badge-cancelled', 'label' => 'Dibatalkan'],
                                ];
                                $st = $statusLabels[$b->status] ?? ['badge' => 'badge-light border', 'label' => ucfirst($b->status)];
                            @endphp
                            <span class="badge {{ $st['badge'] }} px-2 py-1 text-xs font-weight-bold">
                                {{ $st['label'] }}
                            </span>
                        </div>
                    </div>

                    <div class="rental-card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7 d-flex align-items-center mb-3 mb-md-0">
                                <img src="{{ $b->item->image_url }}" class="rental-item-thumb mr-3" alt="{{ $b->item->name }}">
                                <div>
                                    <h6 class="font-weight-bold text-dark mb-1">
                                        <a href="{{ route('items.show', $b->item_id) }}" class="text-dark text-decoration-none">
                                            {{ $b->item->name }}
                                        </a>
                                    </h6>
                                    <div class="text-xs text-muted mb-1">
                                        <i class="fas fa-calendar-alt text-primary mr-1"></i> 
                                        Periode: <strong>{{ \Carbon\Carbon::parse($b->start_date)->format('d M Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($b->end_date)->format('d M Y') }}</strong> ({{ $b->total_days }} Hari)
                                    </div>
                                    <div class="text-xs text-muted">
                                        <i class="fas fa-store text-warning mr-1"></i> Pemilik: <strong>{{ $b->item->owner->name ?? 'Mitra Rental' }}</strong> ({{ $b->item->location }})
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 text-md-right border-left pl-md-4">
                                <div class="text-xs text-muted">Total Pembayaran Sewa</div>
                                <div class="font-weight-bold text-success mb-2" style="font-size: 1.25rem;">
                                    Rp {{ number_format($b->total_price, 0, ',', '.') }}
                                </div>

                                <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                    @php
                                        $ownerPhone = preg_replace('/[^0-9]/', '', $b->item->owner->phone ?? '081298765432');
                                        if (str_starts_with($ownerPhone, '0')) {
                                            $ownerPhone = '62' . substr($ownerPhone, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $ownerPhone }}?text=Halo%20{{ urlencode($b->item->owner->name ?? 'Pemilik') }},%20saya%20terkait%20pesanan%20sewa%20%23BK-{{ $b->id }}%20untuk%20{{ urlencode($b->item->name) }}." 
                                       target="_blank" class="btn btn-outline-success btn-sm font-weight-bold mr-1 mb-1" title="Tanya kondisi barang, janjian COD, atau keterlambatan langsung ke pemilik toko">
                                        <i class="fab fa-whatsapp mr-1"></i> Chat Pemilik (Keluhan Biasa)
                                    </a>

                                    <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold mr-1 mb-1" onclick="openFraudModal({{ $b->id }}, '{{ addslashes($b->item->name) }}', '{{ addslashes($b->item->owner->name ?? 'Pemilik Toko') }}', {{ $b->total_price }})" title="Khusus jika Anda kena tipu (pemilik kabur / blokir kontak / barang fiktif)">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Laporkan Penipuan (Ketipu)
                                    </button>

                                    @if($b->status == 'pending')
                                        <form action="{{ route('profile.rentals.cancel', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan sewa ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-light border text-danger btn-sm font-weight-bold mb-1">
                                                <i class="fas fa-times mr-1"></i> Batalkan
                                            </button>
                                        </form>
                                    @elseif($b->status == 'completed')
                                        @if($b->review)
                                            <span class="badge badge-light border text-warning px-2 py-2 text-xs mb-1" title="{{ $b->review->comment }}">
                                                <i class="fas fa-star text-warning mr-1"></i> Diulas ({{ $b->review->rating }} / 5)
                                            </span>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm font-weight-bold text-dark mb-1" onclick="openReviewModal({{ $b->id }}, '{{ addslashes($b->item->name) }}')">
                                                <i class="fas fa-star mr-1"></i> Beri Ulasan
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="font-weight-bold text-dark">Belum Ada Transaksi Sewa</h5>
                    <p class="text-muted text-sm mb-3">Anda belum memiliki pesanan rental barang dengan status yang dipilih.</p>
                    <a href="{{ route('catalog') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px;">
                        Mulai Sewa Barang Sekarang
                    </a>
                </div>
                @endforelse
            </div>

            <!-- TAB 3: WISHLIST / FAVORIT -->
            @elseif($tab == 'favorites')
            <div class="profile-content-card">
                <div class="content-card-title">Wishlist / Barang Favorit</div>
                <div class="content-card-subtitle">Barang-barang rental yang Anda simpan untuk disewa di kemudian hari.</div>

                <div class="row">
                    @forelse($favorites as $fav)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 border rounded-lg shadow-sm overflow-hidden">
                            <img src="{{ $fav->item->image_url }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $fav->item->name }}">
                            <div class="card-body p-3 d-flex flex-column">
                                <span class="badge badge-light text-muted border text-xs mb-1 align-self-start">{{ $fav->item->category->name }}</span>
                                <h6 class="font-weight-bold text-dark mb-1 text-truncate">
                                    <a href="{{ route('items.show', $fav->item->id) }}" class="text-dark text-decoration-none">
                                        {{ $fav->item->name }}
                                    </a>
                                </h6>
                                <div class="font-weight-bold text-primary mb-2">
                                    Rp {{ number_format($fav->item->price_per_day, 0, ',', '.') }} <small class="text-muted">/ hari</small>
                                </div>
                                <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                    <a href="{{ route('items.show', $fav->item->id) }}" class="btn btn-primary btn-sm font-weight-bold" style="border-radius: 8px;">
                                        Sewa Sekarang
                                    </a>
                                    <form action="{{ route('favorites.toggle', $fav->item_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-light btn-sm text-danger border" title="Hapus dari Wishlist">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="far fa-heart fa-3x text-muted mb-3"></i>
                        <h5 class="font-weight-bold text-dark">Wishlist Masih Kosong</h5>
                        <p class="text-muted text-sm mb-3">Simpan barang rental favorit Anda untuk disewa nanti saat dibutuhkan.</p>
                        <a href="{{ route('catalog') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px;">
                            Jelajahi Katalog Sewa
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 4: UNIT RENTAL MILIK SAYA (KHUSUS OWNER) -->
            @elseif($tab == 'my-items' && $user->isOwner())
            <div class="profile-content-card">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div>
                        <div class="content-card-title">Katalog Unit Rental Milik Saya</div>
                        <div class="content-card-subtitle mb-0">
                            @if($user->store_name)
                                <span class="badge badge-success px-2 py-1 mr-1"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                                <b class="text-dark">{{ $user->store_name }}</b> ({{ $user->store_city }}) • 
                            @endif
                            Kelola unit barang yang Anda sewakan kepada pengguna lain di platform UNO.
                        </div>
                    </div>
                    <a href="{{ route('profile.index', ['tab' => 'add-item']) }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2 my-1" style="border-radius: 10px;">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Unit Rental Baru
                    </a>
                </div>

                <!-- Stats Overview Row -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-2">
                        <div class="stat-banner-card bg-light">
                            <span class="text-xs text-muted text-uppercase font-weight-bold">Total Unit Saya</span>
                            <h3 class="font-weight-bold text-dark mb-0">{{ $myItems->count() }} Unit</h3>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="stat-banner-card bg-light">
                            <span class="text-xs text-muted text-uppercase font-weight-bold">Total Disewa</span>
                            <h3 class="font-weight-bold text-primary mb-0">{{ $incomingBookings->whereIn('status', ['confirmed', 'completed'])->count() }}x Transaksi</h3>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="stat-banner-card bg-light">
                            <span class="text-xs text-muted text-uppercase font-weight-bold">Total Pemasukan Masuk</span>
                            <h3 class="font-weight-bold text-success mb-0">Rp {{ number_format($totalEarned, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Items Table / Grid -->
                <div class="table-responsive border rounded-lg">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 70px;">Foto</th>
                                <th>Unit Barang & Kategori</th>
                                <th>Tarif Harian</th>
                                <th>Status Unit</th>
                                <th>Frekuensi</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myItems as $it)
                            <tr>
                                <td>
                                    <img src="{{ $it->image_url }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $it->name }}">
                                </td>
                                <td>
                                    <a href="{{ route('items.show', $it->id) }}" class="font-weight-bold text-dark text-decoration-none d-block">
                                        {{ $it->name }}
                                    </a>
                                    <span class="badge badge-light border text-muted text-xs">{{ $it->category->name }}</span>
                                    <span class="text-muted text-xs ml-1"><i class="fas fa-map-marker-alt text-danger"></i> {{ $it->location }}</span>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-primary">Rp {{ number_format($it->price_per_day, 0, ',', '.') }}</span>
                                    <span class="text-muted text-xs">/hari</span>
                                </td>
                                <td>
                                    <form action="{{ route('profile.items.status', $it->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <select name="status" class="form-control form-control-sm font-weight-semibold" onchange="this.form.submit()" style="font-size: 0.8rem; width: 140px;">
                                            <option value="available" {{ $it->status == 'available' ? 'selected' : '' }}>🟢 Tersedia</option>
                                            <option value="unavailable" {{ $it->status == 'unavailable' ? 'selected' : '' }}>🔴 Tidak Tersedia</option>
                                            <option value="hidden" {{ $it->status == 'hidden' ? 'selected' : '' }}>⚪ Arsipkan</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <span class="badge badge-success font-weight-bold">{{ $it->bookings_count }}x Sewa</span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('items.show', $it->id) }}" class="btn btn-outline-info btn-sm mr-1" title="Lihat di Katalog">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('profile.items.destroy', $it->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit rental ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Unit">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-store-slash fa-2x mb-2 d-block"></i>
                                    Anda belum memiliki unit rental yang didaftarkan.
                                    <div class="mt-2">
                                        <a href="{{ route('profile.index', ['tab' => 'add-item']) }}" class="btn btn-primary btn-sm font-weight-bold">
                                            Tambah Unit Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 5: PESANAN SEWA MASUK (KHUSUS OWNER) -->
            @elseif($tab == 'incoming-bookings' && $user->isOwner())
            <div class="profile-content-card">
                <div class="content-card-title">Pesanan Sewa Masuk ke Unit Saya</div>
                <div class="content-card-subtitle">Permintaan booking dari penyewa lain yang menyewa barang milik Anda.</div>

                <!-- Filter Chips -->
                <div class="my-3 pb-2 border-bottom d-flex flex-wrap align-items-center">
                    <span class="text-xs text-muted font-weight-bold mr-2 text-uppercase">Status:</span>
                    <a href="{{ route('profile.index', ['tab' => 'incoming-bookings']) }}" class="status-chip {{ !request('incoming_status') ? 'active' : '' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'incoming-bookings', 'incoming_status' => 'pending']) }}" class="status-chip {{ request('incoming_status') == 'pending' ? 'active' : '' }}">
                        <i class="fas fa-hourglass-half text-warning mr-1"></i> Perlu Dikonfirmasi
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'incoming-bookings', 'incoming_status' => 'confirmed']) }}" class="status-chip {{ request('incoming_status') == 'confirmed' ? 'active' : '' }}">
                        <i class="fas fa-check-circle text-primary mr-1"></i> Sedang Disewa
                    </a>
                    <a href="{{ route('profile.index', ['tab' => 'incoming-bookings', 'incoming_status' => 'completed']) }}" class="status-chip {{ request('incoming_status') == 'completed' ? 'active' : '' }}">
                        <i class="fas fa-flag-checkered text-success mr-1"></i> Selesai
                    </a>
                </div>

                @forelse($incomingBookings as $ib)
                <div class="rental-order-card">
                    <div class="rental-card-header">
                        <div class="d-flex align-items-center text-xs">
                            <span class="font-weight-bold text-dark mr-2"><i class="fas fa-inbox text-warning mr-1"></i> Pesanan Masuk</span>
                            <span class="text-muted mr-2">•</span>
                            <span class="text-muted mr-2">{{ $ib->created_at ? $ib->created_at->format('d M Y, H:i') : '-' }}</span>
                            <span class="text-muted mr-2">•</span>
                            <span class="font-weight-semibold text-primary">#BK-{{ $ib->id }}</span>
                        </div>
                        <div>
                            @php
                                $statusLabels = [
                                    'pending' => ['badge' => 'badge-pending', 'label' => 'Menunggu Persetujuan Anda'],
                                    'confirmed' => ['badge' => 'badge-confirmed', 'label' => 'Disetujui / Sedang Berjalan'],
                                    'completed' => ['badge' => 'badge-completed', 'label' => 'Sewa Selesai'],
                                    'cancelled' => ['badge' => 'badge-cancelled', 'label' => 'Dibatalkan'],
                                ];
                                $st = $statusLabels[$ib->status] ?? ['badge' => 'badge-light border', 'label' => ucfirst($ib->status)];
                            @endphp
                            <span class="badge {{ $st['badge'] }} px-2 py-1 text-xs font-weight-bold">
                                {{ $st['label'] }}
                            </span>
                        </div>
                    </div>

                    <div class="rental-card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7 d-flex align-items-center mb-3 mb-md-0">
                                <img src="{{ $ib->item->image_url }}" class="rental-item-thumb mr-3" alt="{{ $ib->item->name }}">
                                <div>
                                    <h6 class="font-weight-bold text-dark mb-1">{{ $ib->item->name }}</h6>
                                    <div class="text-xs text-muted mb-1">
                                        <i class="fas fa-calendar-alt text-primary mr-1"></i> 
                                        Durasi: <strong>{{ \Carbon\Carbon::parse($ib->start_date)->format('d M') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($ib->end_date)->format('d M Y') }}</strong> ({{ $ib->total_days }} Hari)
                                    </div>
                                    <div class="text-xs text-dark font-weight-semibold">
                                        <i class="fas fa-user text-muted mr-1"></i> Penyewa: <span class="text-primary">{{ $ib->renter->name }}</span> ({{ $ib->renter->phone ?? 'Tidak ada No HP' }})
                                    </div>
                                    @if($ib->notes)
                                        <div class="text-xs text-muted mt-1 font-italic bg-light p-1 rounded">
                                            Catatan: "{{ $ib->notes }}"
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-5 text-md-right border-left pl-md-4">
                                <div class="text-xs text-muted">Total Pembayaran Masuk</div>
                                <div class="font-weight-bold text-success mb-2" style="font-size: 1.25rem;">
                                    Rp {{ number_format($ib->total_price, 0, ',', '.') }}
                                </div>

                                <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                    @if($ib->renter->phone)
                                        @php
                                            $renterPhone = preg_replace('/[^0-9]/', '', $ib->renter->phone);
                                            if (str_starts_with($renterPhone, '0')) {
                                                $renterPhone = '62' . substr($renterPhone, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $renterPhone }}?text=Halo%20{{ urlencode($ib->renter->name) }},%20saya%20pemilik%20unit%20{{ urlencode($ib->item->name) }}%20terkait%20pesanan%20sewa%20%23BK-{{ $ib->id }}." 
                                           target="_blank" class="btn btn-outline-success btn-sm font-weight-bold mr-1 mb-1">
                                            <i class="fab fa-whatsapp mr-1"></i> WhatsApp Penyewa
                                        </a>
                                    @endif

                                    @if($ib->status == 'pending')
                                        <form action="{{ route('profile.incoming-bookings.status', $ib->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-primary btn-sm font-weight-bold mr-1 mb-1">
                                                <i class="fas fa-check mr-1"></i> Setujui Sewa
                                            </button>
                                        </form>
                                        <form action="{{ route('profile.incoming-bookings.status', $ib->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak pesanan sewa ini?')">
                                            @csrf
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-outline-danger btn-sm font-weight-bold mb-1">
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($ib->status == 'confirmed')
                                        <form action="{{ route('profile.incoming-bookings.status', $ib->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai pesanan rental ini telah selesai dikembalikan?')">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-success btn-sm font-weight-bold mb-1">
                                                <i class="fas fa-check-double mr-1"></i> Selesaikan Sewa
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <h5 class="font-weight-bold text-dark">Belum Ada Pesanan Masuk</h5>
                    <p class="text-muted text-sm">Pesanan sewa dari pengguna lain untuk barang milik Anda akan muncul di sini.</p>
                </div>
                @endforelse
            </div>

            <!-- TAB 6: TAMBAH UNIT BARU (KHUSUS OWNER) -->
            @elseif($tab == 'add-item' && $user->isOwner())
            <div class="profile-content-card">
                <div class="content-card-title">Tambah Unit Rental Baru</div>
                <div class="content-card-subtitle">Daftarkan barang Anda ke katalog U.N.O untuk mulai disewakan dan menghasilkan pendapatan.</div>

                <form action="{{ route('profile.items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    Nama Unit Barang <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Kamera Sony Alpha A7 IV Kit 28-70mm" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                        Kategori Unit <span class="text-danger">*</span>
                                    </label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                        Tarif Sewa Harian (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="price_per_day" class="form-control" placeholder="Contoh: 150000" min="1000" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                        Kondisi Fisik Unit <span class="text-danger">*</span>
                                    </label>
                                    <select name="condition" class="form-control" required>
                                        <option value="new">Baru (100% Brand New)</option>
                                        <option value="like_new" selected>Like New (Mulus Tanpa Cacat)</option>
                                        <option value="good">Bagus (Fungsi Prima, Lecet Pemakaian Ringan)</option>
                                        <option value="fair">Layak Pakai</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                        Lokasi Pengambilan Unit <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="location" class="form-control" placeholder="Contoh: Surabaya Timur (Rungkut)" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">
                                    Deskripsi Kelengkapan & Ketentuan Sewa <span class="text-danger">*</span>
                                </label>
                                <textarea name="description" rows="4" class="form-control" placeholder="Jelaskan kelengkapan unit (baterai, charger, tas, dll.) serta persyaratan identitas yang dibutuhkan..." required></textarea>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                                    <i class="fas fa-check mr-1"></i> Publikasikan Unit Rental
                                </button>
                                <a href="{{ route('profile.index', ['tab' => 'my-items']) }}" class="btn btn-light border font-weight-bold ml-2 px-3 py-2" style="border-radius: 10px;">
                                    Batal
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded border text-center">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase mb-2 d-block">Foto Utama Unit</label>
                                <div class="mb-3">
                                    <i class="fas fa-camera-retro fa-3x text-muted"></i>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="btn btn-outline-primary btn-sm btn-block font-weight-bold" style="border-radius: 8px; cursor: pointer;">
                                        <i class="fas fa-upload mr-1"></i> Upload File Foto
                                        <input type="file" name="image_file" accept="image/*" class="d-none">
                                    </label>
                                    <small class="text-muted text-xs d-block">Format JPG/PNG/WebP, maks 3MB.</small>
                                </div>
                                <div class="form-group mb-0 text-left mt-3">
                                    <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">Atau Gunakan URL Gambar</label>
                                    <input type="url" name="image_url" class="form-control form-control-sm" placeholder="https://images.unsplash.com/...">
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            <!-- TAB 7: ADUAN PENIPUAN (MESSAGES KE ADMIN PUSAT) -->
            @elseif($tab == 'fraud-messages')
            <div class="profile-content-card">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div>
                        <div class="content-card-title text-danger">
                            <i class="fas fa-shield-alt mr-2"></i> Aduan Penipuan & Pesan Tim Keamanan
                        </div>
                        <div class="content-card-subtitle mb-0">
                            Pusat pengaduan resmi khusus jika Anda mengalami penipuan transaksi sewa (uang ditransfer pemilik kabur, barang fiktif, kontak diblokir).
                        </div>
                    </div>
                </div>

                <div class="alert alert-danger border-0 rounded-lg p-3 mb-4 shadow-sm" style="background: linear-gradient(135deg, #fef2f2 0%, #fff 100%); border-left: 4px solid #ef4444 !important;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x text-danger mr-3"></i>
                        <div class="text-xs text-dark" style="line-height: 1.5;">
                            <strong>Perhatian:</strong> Menu pesan ini dikhususkan bagi pengguna yang mengalami <strong>penipuan sewa</strong>. Untuk pertanyaan spek, janjian COD, atau keluhan kecil, gunakan tombol <strong>Chat Pemilik Toko (WhatsApp)</strong> pada riwayat sewa. Admin Pusat akan memverifikasi bukti Anda dan menindak tegas dengan membekukan akun penipu.
                        </div>
                    </div>
                </div>

                @forelse($myFraudReports as $report)
                <div class="card mb-4 border rounded-lg shadow-sm overflow-hidden">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <span class="badge badge-dark px-2 py-1 mr-2 font-weight-bold">{{ $report->report_code }}</span>
                            <span class="font-weight-bold text-dark">{{ $report->title }}</span>
                        </div>
                        <div>
                            <span class="badge {{ $report->status_badge['class'] }} px-2 py-1 font-weight-bold text-xs">
                                <i class="{{ $report->status_badge['icon'] }} mr-1"></i> {{ $report->status_badge['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-7 border-right pr-md-4">
                                <div class="text-xs text-muted mb-2">
                                    <i class="far fa-clock mr-1"></i> Diajukan: {{ $report->created_at->format('d M Y, H:i') }} WIB
                                </div>
                                <div class="p-3 bg-light rounded text-sm text-dark mb-3" style="line-height: 1.5;">
                                    <strong>Kronologi Aduan:</strong><br>
                                    {{ $report->description }}
                                </div>

                                @if($report->evidence_photo)
                                <div class="mb-3">
                                    <span class="text-xs font-weight-bold text-muted text-uppercase d-block mb-1">Bukti yang Anda Lampirkan:</span>
                                    <a href="{{ asset($report->evidence_photo) }}" target="_blank">
                                        <img src="{{ asset($report->evidence_photo) }}" class="rounded border" style="max-height: 100px; max-width: 160px; object-fit: cover;" alt="Bukti Transfer">
                                    </a>
                                </div>
                                @endif

                                @if($report->reportedUser)
                                <div class="text-xs text-muted">
                                    Pihak yang Dilaporkan: <strong class="text-danger">{{ $report->reportedUser->name }}</strong>
                                    @if($report->reportedUser->status === 'suspended')
                                        <span class="badge badge-danger ml-1">AKUN SUDAH DIBEKUKAN ADMIN</span>
                                    @endif
                                </div>
                                @endif
                            </div>

                            <div class="col-md-5 pl-md-4 mt-3 mt-md-0">
                                <h6 class="font-weight-bold text-dark text-xs text-uppercase mb-2">
                                    <i class="fas fa-comments text-primary mr-1"></i> Percakapan Dengan Admin Pusat
                                </h6>

                                <div class="p-2 bg-light rounded mb-3" style="max-height: 220px; overflow-y: auto;">
                                    @forelse($report->messages as $m)
                                        @if($m->is_admin)
                                            <div class="mb-2 p-2 rounded text-xs bg-primary text-white" style="border-radius: 8px 8px 2px 8px !important;">
                                                <div class="font-weight-bold mb-1"><i class="fas fa-shield-alt mr-1"></i> Admin Pusat:</div>
                                                <div>{{ $m->message }}</div>
                                                <small class="text-white-50 d-block mt-1 text-right">{{ $m->created_at->format('H:i, d M') }}</small>
                                            </div>
                                        @else
                                            <div class="mb-2 p-2 rounded text-xs bg-white border text-dark" style="border-radius: 8px 8px 8px 2px !important;">
                                                <div class="font-weight-bold text-muted mb-1">Anda:</div>
                                                <div>{{ $m->message }}</div>
                                                <small class="text-muted d-block mt-1 text-right">{{ $m->created_at->format('H:i, d M') }}</small>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="text-center py-3 text-muted text-xs">
                                            <i class="fas fa-hourglass-half mr-1 text-warning"></i> Laporan Anda sedang menunggu respon tim Admin Pusat.
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Form Balas Pesan ke Admin -->
                                <form action="{{ route('profile.fraud-reports.reply', $report->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-2">
                                        <input type="text" name="message" class="form-control form-control-sm" placeholder="Ketik pesan balasan ke admin..." required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between text-xs text-muted">
                                        <label class="mb-0" style="cursor: pointer;">
                                            <i class="fas fa-paperclip mr-1 text-primary"></i> Lampirkan Foto Bukti Tambahan
                                            <input type="file" name="attachment" accept="image/*" class="d-none" onchange="alert('Foto bukti dipilih!')">
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-shield-alt fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="font-weight-bold text-dark">Tidak Ada Aduan Penipuan Aktif</h5>
                    <p class="text-muted text-sm mb-3">
                        Jika Anda menjadi korban penipuan pada salah satu transaksi sewa, buka menu <strong>Riwayat Sewa Saya</strong> dan klik tombol <strong>"Laporkan Penipuan (Ketipu)"</strong>.
                    </p>
                    <a href="{{ route('profile.index', ['tab' => 'rentals']) }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px;">
                        Buka Riwayat Sewa
                    </a>
                </div>
                @endforelse
            </div>
            @endif

        </div>

    </div>
</div>

<!-- Modal Beri Ulasan Bintang (Renter) -->
<div class="modal fade" id="modalReviewBooking" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-light border-0 p-4">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fas fa-star text-warning mr-2"></i> Beri Ulasan Unit Rental
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formReviewBooking" method="POST">
                @csrf
                <div class="modal-body p-4 text-center">
                    <p class="text-muted text-sm mb-3">Bagaimana pengalaman Anda menyewa <b id="reviewItemName">Unit Barang</b>?</p>

                    <!-- Interactive Clickable Star Rating -->
                    <div class="rating-stars mb-3">
                        <input type="radio" id="star5" name="rating" value="5" checked><label for="star5"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"><i class="fas fa-star"></i></label>
                    </div>

                    <div class="form-group text-left">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase mb-1">Ulasan / Komentar Anda</label>
                        <textarea name="comment" rows="3" class="form-control" placeholder="Ceritakan kondisi barang, kemudahan serah terima dengan pemilik, dll..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-0">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                    <button type="submit" class="btn btn-warning font-weight-bold text-dark px-4" style="border-radius: 8px;">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Laporkan Penipuan ke Admin Pusat -->
<div class="modal fade" id="modalFraudReport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-danger text-white border-0 p-3">
                <h5 class="modal-title font-weight-bold text-white text-base mb-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Laporkan Kasus Penipuan ke Admin Pusat
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('profile.fraud-reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="fraudBookingId">
                <div class="modal-body p-4">
                    <div class="alert alert-light border text-xs text-muted mb-3" style="border-left: 3px solid #ef4444 !important;">
                        <strong class="text-danger">Peringatan:</strong> Formulir ini <strong>hanya untuk kasus penipuan sewa</strong> (uang sudah ditransfer namun pemilik kabur / memblokir nomor WA / barang tidak pernah ada). Untuk pertanyaan spek barang atau kendala biasa, silakan gunakan tombol Chat Pemilik Toko.
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-xs text-muted text-uppercase mb-1">Transaksi Sewa Bermasalah</label>
                        <div class="p-2 bg-light rounded border text-sm font-weight-bold text-dark" id="fraudItemDesc">
                            Memuat data pesanan...
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-xs text-muted text-uppercase mb-1">
                            Bentuk Kasus Penipuan <span class="text-danger">*</span>
                        </label>
                        <select name="fraud_type" class="form-control" required>
                            <option value="Uang Sudah Ditransfer Pemilik Kabur / Menghilang">Uang Sudah Ditransfer Namun Pemilik Kabur / Menghilang</option>
                            <option value="Nomor WhatsApp Diblokir Setelah Pembayaran">Nomor WhatsApp Diblokir Setelah Pembayaran</option>
                            <option value="Barang Fiktif / Alamat Toko Palsu">Barang Fiktif / Alamat Toko Palsu</option>
                            <option value="Pemilik Meminta Transfer ke Rekening Pribadi Mencurigakan">Pemilik Meminta Transfer ke Rekening Pribadi Mencurigakan</option>
                            <option value="Penggelapan / Pelanggaran Berat Lainnya">Penggelapan / Pelanggaran Berat Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-xs text-muted text-uppercase mb-1">
                            Kronologi Kejadian & Rincian Pesan <span class="text-danger">*</span>
                        </label>
                        <textarea name="message" rows="4" class="form-control" placeholder="Jelaskan secara rinci kronologi kejadian: jam transfer, nomor rekening pelaku, nomor WA pelaku, dan indikasi penipuan..." required minlength="10"></textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-xs text-muted text-uppercase mb-1">
                            Lampiran Bukti Transfer / Screenshot Chat (Opsional)
                        </label>
                        <input type="file" name="evidence" accept="image/*" class="form-control-file text-sm">
                        <small class="text-muted text-xs">Maksimal 3MB (Format JPG/PNG/WebP). Bukti mempercepat tindakan pembekuan akun pelaku.</small>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-0">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4" style="border-radius: 8px;">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Laporan ke Admin Pusat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openFraudModal(bookingId, itemName, ownerName, price) {
        $('#fraudBookingId').val(bookingId);
        $('#fraudItemDesc').html('Booking #BK-' + bookingId + ' • ' + itemName + '<br><small class="text-muted">Pemilik: ' + ownerName + ' | Nilai Sewa: Rp ' + Number(price).toLocaleString('id-ID') + '</small>');
        $('#modalFraudReport').modal('show');
    }

    function openReviewModal(bookingId, itemName) {
        $('#reviewItemName').text(itemName);
        $('#formReviewBooking').attr('action', '/profile/rentals/' + bookingId + '/review');
        $('#modalReviewBooking').modal('show');
    }

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('.user-avatar-img, .rounded-circle.shadow-sm').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
