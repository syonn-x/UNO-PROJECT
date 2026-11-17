<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Baru | U.N.O E-Commerce Rental</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            padding: 30px 15px;
        }
        .register-card {
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 520px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.25s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #0369a1 0%, #1d4ed8 100%);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }
        .role-selector-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            background: #f8fafc;
        }
        .role-selector-card:hover {
            border-color: #93c5fd;
            background: #eff6ff;
        }
        .role-selector-card.active {
            border-color: #2563eb;
            background: #eff6ff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }
        .role-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
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

<div class="w-100 d-flex justify-content-center">
    <div class="register-card">
        <!-- Header -->
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

        <!-- Body -->
        <div class="p-4">
            <h5 class="font-weight-bold text-dark mb-1">Buat Akun Baru</h5>
            <p class="text-muted text-sm mb-4">Pilih peran akun sesuai kebutuhan Anda untuk memulai.</p>

            @if($errors->any())
                <div class="alert alert-danger py-2 text-sm rounded-lg mb-3">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
                @csrf
                <input type="hidden" name="role" id="roleInput" value="{{ old('role', $selectedRole ?? 'renter') }}">

                <!-- Role Selection -->
                <label class="text-xs font-weight-bold text-muted text-uppercase mb-2 d-block">Pilih Jenis Akun</label>
                <div class="row mb-4">
                    <div class="col-6 pr-1">
                        <div class="role-selector-card text-left h-100 {{ old('role', $selectedRole ?? 'renter') === 'renter' ? 'active' : '' }}" onclick="selectRole('renter')" id="cardRenter">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <i class="fas fa-shopping-bag text-primary font-size-lg" style="font-size: 1.25rem;"></i>
                                <span class="badge badge-primary role-badge">Penyewa</span>
                            </div>
                            <div class="font-weight-bold text-dark text-sm mt-1">Penyewa Barang</div>
                            <div class="text-muted" style="font-size: 0.72rem; line-height: 1.3;">Sewa kamera, tenda, gadget & alat lainnya</div>
                        </div>
                    </div>
                    <div class="col-6 pl-1">
                        <div class="role-selector-card text-left h-100 {{ old('role', $selectedRole ?? 'renter') === 'owner' ? 'active' : '' }}" onclick="selectRole('owner')" id="cardOwner">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <i class="fas fa-store text-warning font-size-lg" style="font-size: 1.25rem;"></i>
                                <span class="badge badge-warning text-dark role-badge">Mitra Owner</span>
                            </div>
                            <div class="font-weight-bold text-dark text-sm mt-1">Pemilik Rental</div>
                            <div class="text-muted" style="font-size: 0.72rem; line-height: 1.3;">Sewakan barang Anda & dapatkan penghasilan</div>
                        </div>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="form-group mb-3">
                    <label class="text-xs font-weight-bold text-muted text-uppercase" id="nameLabel">
                        {{ old('role', $selectedRole ?? 'renter') === 'owner' ? 'Nama Pemilik / Rental' : 'Nama Lengkap' }}
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-user text-muted"></i></span>
                        </div>
                        <input type="text" name="name" class="form-control border-left-0" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="text-xs font-weight-bold text-muted text-uppercase">Alamat Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                        </div>
                        <input type="email" name="email" class="form-control border-left-0" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="text-xs font-weight-bold text-muted text-uppercase">No. WhatsApp / HP</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fab fa-whatsapp text-muted"></i></span>
                        </div>
                        <input type="text" name="phone" class="form-control border-left-0" placeholder="081234567890" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <label class="text-xs font-weight-bold text-muted text-uppercase">Kata Sandi</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-lock text-muted"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control border-left-0" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-muted text-uppercase">Ulangi Sandi</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-check-circle text-muted"></i></span>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control border-left-0" placeholder="Ketik ulang sandi" required>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border py-2 px-3 text-xs text-muted mb-4 rounded-lg d-flex align-items-center">
                    <i class="fas fa-info-circle text-primary mr-2" style="font-size: 1rem;"></i>
                    <span id="roleNotice">
                        {{ old('role', $selectedRole ?? 'renter') === 'owner' 
                            ? 'Akun Mitra Owner dapat mendaftarkan barang rental dan mengelola transaksi sewa.' 
                            : 'Akun Penyewa digunakan untuk menjelajahi katalog dan menyewa barang dengan aman.' }}
                    </span>
                </div>

                <button type="submit" class="btn btn-gradient btn-block mb-3" id="submitBtn">
                    <i class="fas fa-user-plus mr-1"></i> 
                    <span id="btnText">{{ old('role', $selectedRole ?? 'renter') === 'owner' ? 'Daftar sebagai Mitra Rental (Owner)' : 'Daftar sebagai Penyewa (Renter)' }}</span>
                </button>
            </form>

            <div class="text-center pt-2">
                <span class="text-sm text-muted">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-sm font-weight-bold text-primary ml-1">Masuk Sekarang</a>
            </div>
        </div>

        <div class="bg-light p-3 text-center text-xs text-muted border-top">
            <i class="fas fa-shield-alt text-success mr-1"></i> Data akun Anda terlindungi dengan enkripsi standar industri.
        </div>
    </div>
</div>

<script>
function selectRole(role) {
    document.getElementById('roleInput').value = role;
    const cardRenter = document.getElementById('cardRenter');
    const cardOwner = document.getElementById('cardOwner');
    const nameLabel = document.getElementById('nameLabel');
    const roleNotice = document.getElementById('roleNotice');
    const btnText = document.getElementById('btnText');

    if (role === 'renter') {
        cardRenter.classList.add('active');
        cardOwner.classList.remove('active');
        nameLabel.textContent = 'Nama Lengkap';
        roleNotice.textContent = 'Akun Penyewa digunakan untuk menjelajahi katalog dan menyewa barang dengan aman.';
        btnText.textContent = 'Daftar sebagai Penyewa (Renter)';
    } else {
        cardOwner.classList.add('active');
        cardRenter.classList.remove('active');
        nameLabel.textContent = 'Nama Pemilik / Rental';
        roleNotice.textContent = 'Akun Mitra Owner dapat mendaftarkan barang rental dan mengelola transaksi sewa.';
        btnText.textContent = 'Daftar sebagai Mitra Rental (Owner)';
    }
}
</script>

</body>
</html>
