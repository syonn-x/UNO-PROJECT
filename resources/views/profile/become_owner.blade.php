<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran Mitra Rental (Owner) | U.N.O Platform</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

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
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }

        .uno-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
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

        /* Stepper Header (Tokopedia Style) */
        .stepper-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 30px 0 40px 0;
        }
        .stepper-wrap::before {
            content: '';
            position: absolute;
            top: 22px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: #e2e8f0;
            z-index: 1;
        }
        .stepper-progress-line {
            position: absolute;
            top: 22px;
            left: 10%;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #0284c7, #03ac0e);
            z-index: 2;
            transition: width 0.4s ease;
        }
        .step-item {
            position: relative;
            z-index: 3;
            text-align: center;
            flex: 1;
            cursor: pointer;
        }
        .step-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px auto;
            font-weight: 700;
            color: #64748b;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .step-item.active .step-circle {
            background: #0284c7;
            border-color: #0284c7;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }
        .step-item.completed .step-circle {
            background: #03ac0e;
            border-color: #03ac0e;
            color: #ffffff;
        }
        .step-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
        }
        .step-item.active .step-title {
            color: #0284c7;
        }
        .step-item.completed .step-title {
            color: #03ac0e;
        }

        /* Card Container */
        .onboarding-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            padding: 36px 32px;
            margin-bottom: 40px;
        }

        .step-pane {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }
        .step-pane.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-label-custom {
            font-size: 0.82rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-control-custom {
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 0.92rem;
            transition: all 0.2s;
        }
        .form-control-custom:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        .kyc-badge-info {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 14px 18px;
            color: #166534;
            font-size: 0.84rem;
        }

        .terms-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
            transition: border-color 0.2s;
        }
        .terms-box:hover {
            border-color: #0284c7;
        }

        .btn-prev {
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
        }
        .btn-next, .btn-submit-owner {
            border-radius: 10px;
            padding: 10px 30px;
            font-weight: 700;
            background: linear-gradient(135deg, #0284c7 0%, #03ac0e 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.25);
        }
        .btn-next:hover, .btn-submit-owner:hover {
            color: white;
            opacity: 0.95;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="uno-nav">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('profile.index') }}" class="d-flex align-items-center text-decoration-none">
            <div class="brand-icon-box mr-2">
                <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
            </div>
            <div>
                <span class="font-weight-bold text-dark" style="font-size: 1.25rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                <span class="d-block text-muted text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.2px; font-weight: 700;">USE NOT OWN</span>
            </div>
        </a>
        <div>
            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-arrow-left mr-1"></i> Batal & Kembali ke Profil
            </a>
        </div>
    </div>
</nav>

<div class="container py-4">

    <!-- Hero Title -->
    <div class="text-center mb-4">
        <span class="badge badge-warning text-dark font-weight-bold px-3 py-1 mb-2" style="border-radius: 20px; font-size: 0.75rem;">
            <i class="fas fa-store mr-1"></i> Buka Toko Rental di UNO
        </span>
        <h2 class="font-weight-bold text-dark">Langkah Pendaftaran Mitra Rental (Owner)</h2>
        <p class="text-muted text-sm mx-auto" style="max-width: 650px;">
            Untuk menjaga keamanan komunitas penyewa dan pemilik aset, calon Mitra Rental hanya perlu melengkapi verifikasi profil toko, identitas KTP resmi, dan komitmen layanan.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-lg shadow-sm mb-4" role="alert">
            <h6 class="font-weight-bold mb-2"><i class="fas fa-exclamation-circle mr-1"></i> Mohon lengkapi data verifikasi berikut:</h6>
            <ul class="mb-0 pl-3 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Stepper Navigation Header (Tokopedia Style) -->
    <div class="stepper-wrap">
        <div class="stepper-progress-line" id="stepperProgress"></div>

        <div class="step-item active" id="stepIndicator1" onclick="jumpToStep(1)">
            <div class="step-circle" id="circle1">1</div>
            <div class="step-title">Profil Toko & Lokasi</div>
        </div>

        <div class="step-item" id="stepIndicator2" onclick="jumpToStep(2)">
            <div class="step-circle" id="circle2">2</div>
            <div class="step-title">Verifikasi Identitas KTP</div>
        </div>

        <div class="step-item" id="stepIndicator3" onclick="jumpToStep(3)">
            <div class="step-circle" id="circle3">3</div>
            <div class="step-title">Syarat & Komitmen</div>
        </div>
    </div>

    <!-- Onboarding Form -->
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="onboarding-card">
                <form action="{{ route('profile.become-owner.submit') }}" method="POST" enctype="multipart/form-data" id="ownerOnboardingForm">
                    @csrf

                    <!-- ============================================== -->
                    <!-- LANGKAH 1: PROFIL TOKO & LOKASI OPERASIONAL -->
                    <!-- ============================================== -->
                    <div class="step-pane active" id="stepPane1">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fas fa-store"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-0">Langkah 1: Informasi Toko / Rental Anda</h5>
                                <small class="text-muted">Nama dan deskripsi ini akan dilihat oleh penyewa di halaman katalog produk Anda.</small>
                            </div>
                        </div>
                        <hr class="mb-4">

                        <div class="form-group mb-3">
                            <label class="form-label-custom">Nama Toko / Brand Rental <span class="text-danger">*</span></label>
                            <input type="text" name="store_name" id="store_name" class="form-control form-control-custom" 
                                   placeholder="Contoh: Surya Camera & Drone Rental" value="{{ old('store_name', $user->store_name ?? $user->name . ' Rental') }}" required>
                            <small class="text-muted text-xs">Minimal 3 karakter. Gunakan nama yang mudah diingat calon penyewa.</small>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label-custom">Slogan / Deskripsi Singkat Rental <span class="text-danger">*</span></label>
                            <textarea name="store_description" id="store_description" rows="3" class="form-control form-control-custom" 
                                      placeholder="Contoh: Menyewakan aneka peralatan fotografi, lensa Sony & Canon, stabilizer gimbal, dan aksesoris outdoor resmi terawat." required>{{ old('store_description', $user->store_description) }}</textarea>
                            <small class="text-muted text-xs">Jelaskan jenis barang atau keunggulan unit rental yang Anda sediakan (min. 10 karakter).</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Kota Operasional Serah Terima <span class="text-danger">*</span></label>
                                <input type="text" name="store_city" id="store_city" class="form-control form-control-custom" 
                                       placeholder="Contoh: Jakarta Selatan / Surabaya" value="{{ old('store_city', $user->store_city ?? 'Jakarta Selatan') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Nomor WhatsApp Aktif Toko <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control form-control-custom" 
                                       placeholder="Contoh: 081298765432" value="{{ old('phone', $user->phone) }}" required>
                                <small class="text-muted text-xs">Penyewa akan menghubungi nomor ini untuk koordinasi serah terima barang.</small>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Alamat Lengkap Toko / Titik Penjemputan Barang <span class="text-danger">*</span></label>
                            <textarea name="store_address" id="store_address" rows="2" class="form-control form-control-custom" 
                                      placeholder="Contoh: Jl. Tebet Raya No. 45B, Tebet Barat, Jakarta Selatan (Patokan seberang Stasiun Tebet)" required>{{ old('store_address', $user->store_address) }}</textarea>
                            <small class="text-muted text-xs">Alamat pengambilan dan pengembalian unit sewa oleh kurir / penyewa.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-next" onclick="validateAndGoStep(1, 2)">
                                Lanjut ke Verifikasi Identitas <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- LANGKAH 2: VERIFIKASI IDENTITAS KTP -->
                    <!-- ============================================== -->
                    <div class="step-pane" id="stepPane2">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-0">Langkah 2: Verifikasi Identitas KTP (Legalitas Mitra)</h5>
                                <small class="text-muted">Verifikasi kartu identitas resmi KTP untuk menjamin keamanan dan keaslian pemilik rental.</small>
                            </div>
                        </div>
                        <hr class="mb-4">

                        <div class="kyc-badge-info mb-4">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <strong>Keamanan Data Terjamin:</strong> NIK dan foto KTP Anda disimpan secara aman dan terenkripsi. Data ini hanya digunakan oleh Admin Pusat U.N.O untuk validasi legalitas identitas mitra demi ekosistem sewa yang aman dan terpercaya.
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Nomor Induk Kependudukan (NIK KTP) <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" maxlength="16" class="form-control form-control-custom" 
                                   placeholder="Masukkan 16 digit NIK KTP Anda" value="{{ old('nik', $user->nik) }}" required>
                            <small class="text-muted text-xs">Wajib 16 digit angka sesuai KTP resmi Republik Indonesia.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Upload Foto KTP Asli (e-KTP) <span class="text-danger">*</span></label>
                            <div class="p-3 border rounded bg-white text-center mb-2" style="border: 2px dashed #cbd5e1 !important;">
                                <i class="fas fa-id-card fa-3x text-muted mb-2 d-block"></i>
                                <span class="font-weight-bold text-dark text-sm d-block">Pilih file foto e-KTP yang jelas dan terbaca</span>
                                <small class="text-muted text-xs d-block mb-3">Format: JPG, PNG, atau WEBP. Maksimal 3MB. Pastikan seluruh teks KTP terlihat jelas.</small>
                                <input type="file" name="id_card_file" id="id_card_file" class="form-control-file d-inline-block" accept="image/*" style="max-width: 300px;">
                            </div>
                            
                            @if($user->id_card_photo)
                                <div class="mt-2 text-xs text-success">
                                    <i class="fas fa-check-circle mr-1"></i> Foto KTP sebelumnya telah tersimpan. Unggah file baru hanya jika ingin menggantinya.
                                </div>
                            @endif

                            <div class="mt-2 text-xs text-muted">
                                Atau cantumkan URL Foto KTP langsung:
                                <input type="url" name="id_card_url" class="form-control form-control-sm form-control-custom mt-1" 
                                       placeholder="https://..." value="{{ old('id_card_url') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-prev" onclick="jumpToStep(1)">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Langkah 1
                            </button>
                            <button type="button" class="btn btn-next" onclick="validateAndGoStep(2, 3)">
                                Lanjut ke Syarat & Ketentuan <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- LANGKAH 3: SYARAT, KETENTUAN & KOMITMEN KUALITAS -->
                    <!-- ============================================== -->
                    <div class="step-pane" id="stepPane3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning text-dark rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-0">Langkah 3: Syarat Layanan & Komitmen Mitra Rental</h5>
                                <small class="text-muted">Harap membaca dan menyetujui komitmen transparansi serta keamanan sewa barang.</small>
                            </div>
                        </div>
                        <hr class="mb-4">

                        <div class="terms-box">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="agree_ownership" class="custom-control-input" id="agreeOwnership" value="1" {{ old('agree_ownership') ? 'checked' : '' }} required>
                                <label class="custom-control-label font-weight-bold text-dark text-sm" for="agreeOwnership">
                                    Pernyataan Kepemilikan Barang Asli & Sah
                                </label>
                                <div class="text-muted text-xs mt-1">
                                    Saya menyatakan bahwa seluruh barang yang saya daftarkan ke katalog rental adalah milik sah pribadi/badan usaha saya, bukan barang curian, bukan barang sengketa, dan tidak melanggar hukum RI.
                                </div>
                            </div>
                        </div>

                        <div class="terms-box">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="agree_condition" class="custom-control-input" id="agreeCondition" value="1" {{ old('agree_condition') ? 'checked' : '' }} required>
                                <label class="custom-control-label font-weight-bold text-dark text-sm" for="agreeCondition">
                                    Jaminan Kelayakan Fungsi & Kebersihan Unit
                                </label>
                                <div class="text-muted text-xs mt-1">
                                    Saya berkomitmen untuk merawat unit barang, memastikan kelengkapan fungsi sebelum diserahkan, serta melayani penyewa dengan sopan dan profesional.
                                </div>
                            </div>
                        </div>

                        <div class="terms-box">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="agree_terms" class="custom-control-input" id="agreeTerms" value="1" {{ old('agree_terms') ? 'checked' : '' }} required>
                                <label class="custom-control-label font-weight-bold text-dark text-sm" for="agreeTerms">
                                    Persetujuan Kebijakan Komisi & Ketentuan UNO Rental
                                </label>
                                <div class="text-muted text-xs mt-1">
                                    Saya menyetujui seluruh aturan pemesanan, sistem penyelesaian komplain, serta kebijakan perlindungan dana sewa yang berlaku di platform UNO.
                                </div>
                            </div>
                        </div>

                        <!-- Summary Confirmation Box -->
                        <div class="card bg-light border-0 rounded-lg p-3 my-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success fa-2x mr-3"></i>
                                <div>
                                    <div class="font-weight-bold text-dark text-sm">Akun Siap Diverifikasi & Diaktifkan</div>
                                    <small class="text-muted">Setelah menekan tombol di bawah, status akun Anda akan langsung aktif sebagai Mitra Rental (Owner) resmi.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-prev" onclick="jumpToStep(2)">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Langkah 2
                            </button>
                            <button type="submit" class="btn btn-submit-owner font-weight-bold">
                                <i class="fas fa-check-circle mr-1"></i> Selesaikan & Buka Toko Rental Sekarang
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let currentStep = 1;

    function jumpToStep(step) {
        if (step > currentStep) {
            if (!validateStep(currentStep)) return;
        }

        currentStep = step;
        updateStepperUI();
    }

    function validateAndGoStep(fromStep, toStep) {
        if (!validateStep(fromStep)) {
            return;
        }
        currentStep = toStep;
        updateStepperUI();
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    function validateStep(step) {
        if (step === 1) {
            const storeName = $('#store_name').val().trim();
            const storeDesc = $('#store_description').val().trim();
            const storeCity = $('#store_city').val().trim();
            const phone = $('#phone').val().trim();
            const address = $('#store_address').val().trim();

            if (!storeName || storeName.length < 3) {
                alert('Silakan isi Nama Toko / Rental minimal 3 karakter.');
                $('#store_name').focus();
                return false;
            }
            if (!storeDesc || storeDesc.length < 10) {
                alert('Silakan isi Deskripsi Rental minimal 10 karakter.');
                $('#store_description').focus();
                return false;
            }
            if (!storeCity) {
                alert('Silakan isi Kota operasional rental Anda.');
                $('#store_city').focus();
                return false;
            }
            if (!phone || phone.length < 10) {
                alert('Silakan isi Nomor WhatsApp aktif minimal 10 digit.');
                $('#phone').focus();
                return false;
            }
            if (!address || address.length < 10) {
                alert('Silakan isi Alamat lengkap penjemputan barang minimal 10 karakter.');
                $('#store_address').focus();
                return false;
            }
            return true;
        }

        if (step === 2) {
            const nik = $('#nik').val().trim();

            if (!nik || nik.length !== 16 || !/^\d+$/.test(nik)) {
                alert('NIK KTP wajib berupa 16 digit angka valid sesuai KTP resmi.');
                $('#nik').focus();
                return false;
            }
            return true;
        }

        return true;
    }

    function updateStepperUI() {
        $('.step-pane').removeClass('active');
        $('#stepPane' + currentStep).addClass('active');

        // Progress bar width
        let progressPercent = 0;
        if (currentStep === 2) progressPercent = 40;
        if (currentStep === 3) progressPercent = 80;
        $('#stepperProgress').css('width', progressPercent + '%');

        // Update items
        for (let i = 1; i <= 3; i++) {
            const $item = $('#stepIndicator' + i);
            const $circle = $('#circle' + i);

            $item.removeClass('active completed');
            if (i < currentStep) {
                $item.addClass('completed');
                $circle.html('<i class="fas fa-check"></i>');
            } else if (i === currentStep) {
                $item.addClass('active');
                $circle.text(i);
            } else {
                $circle.text(i);
            }
        }
    }
</script>

</body>
</html>
