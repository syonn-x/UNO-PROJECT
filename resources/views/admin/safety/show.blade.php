@extends('layouts.admin')

@section('title', 'Detail Kasus #' . $report->report_code)
@section('page_title', 'Investigasi Kasus #' . $report->report_code)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Pusat</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Pesan Aduan</a></li>
    <li class="breadcrumb-item active">#{{ $report->report_code }}</li>
@endsection

@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-lg border-0 shadow-sm mb-3" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-lg border-0 shadow-sm mb-3" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Top Navigation & Action Header -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-white border shadow-sm rounded-pill mr-2 text-dark font-weight-500">
            <i class="fas fa-arrow-left mr-1 text-muted"></i> Kembali
        </a>
        <span class="badge badge-light border text-dark px-2 py-1 mr-2 font-weight-bold">
            #{{ $report->report_code }}
        </span>
        <span class="badge {{ $report->status_badge['class'] }} px-2 py-1 font-weight-bold">
            <i class="{{ $report->status_badge['icon'] }} mr-1"></i> {{ $report->status_badge['label'] }}
        </span>
    </div>
    <div class="mt-2 mt-sm-0">
        <a href="{{ route('admin.safety-reports.print', ['id' => $report->id]) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill font-weight-500 shadow-sm">
            <i class="fas fa-print mr-1"></i> Cetak Berita Acara
        </a>
    </div>
</div>

<div class="row">
    <!-- Left Column (8): Kasus & Percakapan -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg mb-4" style="border-radius: 12px; overflow: hidden;">
            <!-- Header Ringkasan Kasus -->
            <div class="card-header bg-white border-bottom p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-xs text-uppercase font-weight-bold text-muted mb-1">
                            <span class="text-danger font-weight-bold">Aduan Penipuan</span> • {{ $report->category_label }}
                        </div>
                        <h4 class="font-weight-bold text-dark mb-1">{{ $report->title }}</h4>
                        <div class="text-muted text-xs">
                            <i class="far fa-clock mr-1"></i> Dilaporkan {{ $report->created_at->format('d M Y, H:i') }} WIB oleh <strong>{{ $report->reporter->name ?? 'Korban' }}</strong>
                            @if($report->resolved_at)
                                • <span class="text-success"><i class="fas fa-check-circle mr-1"></i> Tuntas {{ $report->resolved_at->format('d M Y, H:i') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Booking Terkait (Jika Ada) -->
                @if($report->booking)
                <div class="mt-3 p-2 px-3 bg-light rounded-lg border d-flex align-items-center justify-content-between flex-wrap text-sm" style="border-radius: 8px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-box text-primary mr-2"></i>
                        <span>Sewa: <strong>{{ $report->booking->item->name ?? 'Barang Sewa' }}</strong> (#BK-{{ $report->booking->id }})</span>
                    </div>
                    <div class="text-muted text-xs">
                        Total: <strong class="text-dark">Rp {{ number_format($report->booking->total_price, 0, ',', '.') }}</strong> • Status: <span class="badge badge-light border">{{ strtoupper($report->booking->status) }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Thread Pesan / Percakapan -->
            <div class="card-body p-4" style="background-color: #f8fafc; max-height: 520px; overflow-y: auto;">
                <div class="text-center mb-3">
                    <span class="badge badge-light text-muted border text-xs px-2 py-1">Kronologi Percakapan & Aduan</span>
                </div>

                <!-- Pesan Awal Korban (Kasus Awal) -->
                <div class="d-flex mb-4">
                    <img src="{{ $report->reporter->avatar_url ?? 'https://ui-avatars.com/api/?name=Korban' }}" class="rounded-circle border mr-3" style="width: 38px; height: 38px; object-fit: cover;" alt="Korban">
                    <div style="max-width: 82%;">
                        <div class="d-flex align-items-center mb-1">
                            <span class="font-weight-bold text-dark text-sm mr-2">{{ $report->reporter->name ?? 'Pelapor' }}</span>
                            <span class="badge badge-light border text-xs text-muted">Pelapor</span>
                            <span class="text-muted text-xs ml-2">{{ $report->created_at->format('H:i - d M Y') }}</span>
                        </div>
                        <div class="p-3 bg-white rounded-lg shadow-sm border text-dark text-sm" style="border-radius: 12px 12px 12px 2px; line-height: 1.5;">
                            {{ $report->description }}

                            <!-- Bukti Foto Korban (Jika Ada) -->
                            @if($report->evidence_photo)
                            <div class="mt-3 pt-2 border-top">
                                <div class="text-xs font-weight-bold text-muted mb-2">
                                    <i class="fas fa-paperclip mr-1 text-danger"></i> Bukti Lampiran:
                                </div>
                                <a href="{{ asset($report->evidence_photo) }}" target="_blank" class="d-inline-block">
                                    <img src="{{ asset($report->evidence_photo) }}" class="rounded border shadow-sm" style="max-height: 160px; max-width: 100%; object-fit: cover;" alt="Bukti Lampiran">
                                </a>
                                <div class="text-xs text-muted mt-1"><i class="fas fa-search-plus mr-1"></i> Klik untuk perbesar gambar</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Balasan Berikutnya -->
                @foreach($report->messages as $msg)
                    @if($msg->is_admin)
                        <!-- Admin Balasan (Right) -->
                        <div class="d-flex justify-content-end mb-4">
                            <div style="max-width: 82%; text-align: right;">
                                <div class="d-flex align-items-center justify-content-end mb-1">
                                    <span class="text-muted text-xs mr-2">{{ $msg->created_at->format('H:i - d M Y') }}</span>
                                    <span class="badge badge-primary px-2 py-0.5 text-xs mr-1 font-weight-bold">Admin UNO</span>
                                    <span class="font-weight-bold text-dark text-sm">{{ $msg->user->name ?? 'Admin' }}</span>
                                </div>
                                <div class="p-3 bg-primary text-white rounded-lg shadow-sm text-left text-sm" style="border-radius: 12px 12px 2px 12px; line-height: 1.5; display: inline-block;">
                                    {{ $msg->message }}
                                    @if($msg->attachment)
                                        <div class="mt-2 pt-2 border-top border-white-50">
                                            <a href="{{ asset($msg->attachment) }}" target="_blank" class="text-white font-weight-bold text-xs">
                                                <i class="fas fa-paperclip mr-1"></i> Lihat Lampiran Admin
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-3">
                                <div style="width: 38px; height: 38px; background: #0284c7; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.95rem;">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Korban Balasan (Left) -->
                        <div class="d-flex mb-4">
                            <img src="{{ $msg->user->avatar_url ?? 'https://ui-avatars.com/api/?name=Korban' }}" class="rounded-circle border mr-3" style="width: 38px; height: 38px; object-fit: cover;" alt="Korban">
                            <div style="max-width: 82%;">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="font-weight-bold text-dark text-sm mr-2">{{ $msg->user->name ?? 'Korban' }}</span>
                                    <span class="badge badge-light border text-xs text-muted">Pelapor</span>
                                    <span class="text-muted text-xs ml-2">{{ $msg->created_at->format('H:i - d M Y') }}</span>
                                </div>
                                <div class="p-3 bg-white rounded-lg shadow-sm border text-dark text-sm" style="border-radius: 12px 12px 12px 2px; line-height: 1.5;">
                                    {{ $msg->message }}
                                    @if($msg->attachment)
                                        <div class="mt-2 pt-2 border-top">
                                            <a href="{{ asset($msg->attachment) }}" target="_blank" class="text-primary font-weight-bold text-xs">
                                                <i class="fas fa-paperclip mr-1"></i> Lihat Lampiran Bukti
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Footer: Form Balas Pesan -->
            <div class="card-footer bg-white border-top p-4">
                <form action="{{ route('admin.messages.reply', $report->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Quick Templates Chips -->
                    <div class="d-flex align-items-center flex-wrap mb-2">
                        <span class="text-muted text-xs font-weight-bold mr-2"><i class="fas fa-bolt text-warning mr-1"></i> Balas Cepat:</span>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill mr-1 mb-1" onclick="setQuickMessage('Halo, laporan Anda telah kami terima dan bukti sedang kami telusuri bersama tim. Mohon tunggu proses investigasi.')">
                            Penerimaan Laporan
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill mr-1 mb-1" onclick="setQuickMessage('Mohon kirimkan bukti transfer tambahan berupa tangkapan layar yang menampilkan nomor rekening dan tanggal transaksi secara jelas.')">
                            Minta Bukti Tambahan
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill mr-1 mb-1" onclick="setQuickMessage('Akun terduga pelaku telah resmi kami BEKUKAN (SUSPENDED). Pelaku tidak dapat lagi melakukan transaksi di sistem.')">
                            Akun Pelaku Dibekukan
                        </button>
                    </div>

                    <!-- Input Pesan -->
                    <div class="form-group mb-3">
                        <textarea name="message" id="adminReplyTextarea" class="form-control" rows="3" placeholder="Tulis pesan respon resmi untuk korban..." style="border-radius: 10px; resize: vertical;" required></textarea>
                    </div>

                    <!-- Options Row -->
                    <div class="row align-items-center">
                        <div class="col-md-5 mb-2 mb-md-0">
                            <label class="text-xs text-muted font-weight-bold mb-1 d-block">Status Investigasi:</label>
                            <select name="status" class="form-control form-control-sm rounded" style="font-weight: 500;">
                                <option value="investigating" {{ $report->status == 'investigating' ? 'selected' : '' }}>💬 Sedang Ditangani (Investigating)</option>
                                <option value="action_taken" {{ $report->status == 'action_taken' ? 'selected' : '' }}>🚨 Sanksi Diberikan / Akun Dibekukan</option>
                                <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>✅ Kasus Tuntas / Selesai (Resolved)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="text-xs text-muted font-weight-bold mb-1 d-block">Lampiran Foto (Opsional):</label>
                            <input type="file" name="attachment" accept="image/*" class="form-control-file text-xs">
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="submit" class="btn btn-primary font-weight-bold btn-block rounded-pill shadow-sm" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fas fa-paper-plane mr-1"></i> Kirim Pesan
                            </button>
                        </div>
                    </div>

                    <!-- Checkbox Bekukan Pelaku (Jika belum dibekukan) -->
                    @if($report->reportedUser && $report->reportedUser->status !== 'suspended')
                    <div class="mt-3 p-2 px-3 bg-light rounded border border-light">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="suspendCheckbox" name="suspend_reported_user" value="1">
                            <label class="custom-control-label font-weight-bold text-danger text-sm" for="suspendCheckbox">
                                <i class="fas fa-user-slash mr-1"></i> Sekaligus bekukan akun pelaku ({{ $report->reportedUser->name }})
                            </label>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column (4): Pihak Terkait (Terlapor & Pelapor) -->
    <div class="col-lg-4">
        <!-- Single Unified Card: Pihak Terlibat -->
        <div class="card border-0 shadow-sm rounded-lg mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-users text-primary mr-2"></i> Pihak Terkait
                </h6>
            </div>
            <div class="card-body p-4">
                
                <!-- 1. Terduga Pelaku (Dilaporkan) -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-xs text-uppercase font-weight-bold text-danger">
                            <i class="fas fa-user-times mr-1"></i> Terduga Pelaku
                        </span>
                        @if($report->reportedUser && $report->reportedUser->status === 'suspended')
                            <span class="badge badge-danger text-xs font-weight-bold px-2 py-0.5">
                                <i class="fas fa-ban mr-1"></i> Dibekukan
                            </span>
                        @else
                            <span class="badge badge-success text-xs font-weight-bold px-2 py-0.5">
                                <i class="fas fa-check mr-1"></i> Akun Aktif
                            </span>
                        @endif
                    </div>

                    @if($report->reportedUser)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $report->reportedUser->avatar_url ?? 'https://ui-avatars.com/api/?name=Pelaku' }}" class="rounded-circle border mr-3" style="width: 44px; height: 44px; object-fit: cover;" alt="Pelaku">
                            <div class="overflow-hidden">
                                <h6 class="font-weight-bold text-dark mb-0 text-truncate">{{ $report->reportedUser->name }}</h6>
                                <div class="text-muted text-xs text-truncate">{{ $report->reportedUser->email }}</div>
                            </div>
                        </div>

                        <div class="bg-light rounded p-2 px-3 text-xs mb-3">
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">WhatsApp</span>
                                <span class="font-weight-bold text-dark">{{ $report->reportedUser->phone ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">Peran</span>
                                <span class="font-weight-bold text-dark">{{ strtoupper($report->reportedUser->role) }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted">Toko</span>
                                <span class="font-weight-bold text-dark text-truncate ml-2">{{ $report->reportedUser->store_name ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- 1-Click Suspend Button -->
                        @if($report->reportedUser->status !== 'suspended')
                            <form action="{{ route('admin.messages.suspend-user', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MEMBEKUKAN akun {{ addslashes($report->reportedUser->name) }}?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-block font-weight-bold rounded-pill shadow-sm">
                                    <i class="fas fa-user-slash mr-1"></i> Bekukan Akun Pelaku
                                </button>
                            </form>
                        @else
                            <div class="text-center p-2 rounded bg-light border border-danger-50 text-danger text-xs font-weight-bold">
                                <i class="fas fa-lock mr-1"></i> Akun pelaku telah dibekukan.
                            </div>
                        @endif
                    @else
                        <div class="text-muted text-xs">Data terlapor tidak ditemukan.</div>
                    @endif
                </div>

                <hr class="my-3 border-light">

                <!-- 2. Pelapor (Korban) -->
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-xs text-uppercase font-weight-bold text-primary">
                            <i class="fas fa-user-check mr-1"></i> Pelapor (Korban)
                        </span>
                        <span class="badge badge-light border text-xs text-muted">
                            {{ strtoupper($report->reporter->role ?? 'MEMBER') }}
                        </span>
                    </div>

                    @if($report->reporter)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $report->reporter->avatar_url ?? 'https://ui-avatars.com/api/?name=Korban' }}" class="rounded-circle border mr-3" style="width: 44px; height: 44px; object-fit: cover;" alt="Korban">
                            <div class="overflow-hidden">
                                <h6 class="font-weight-bold text-dark mb-0 text-truncate">{{ $report->reporter->name }}</h6>
                                <div class="text-muted text-xs text-truncate">{{ $report->reporter->email }}</div>
                            </div>
                        </div>

                        <div class="bg-light rounded p-2 px-3 text-xs mb-3">
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">WhatsApp</span>
                                <span class="font-weight-bold text-dark">{{ $report->reporter->phone ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted">Member Sejak</span>
                                <span class="font-weight-bold text-dark">{{ $report->reporter->created_at ? $report->reporter->created_at->format('d M Y') : '-' }}</span>
                            </div>
                        </div>

                        @if($report->reporter->phone)
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $report->reporter->phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($report->reporter->name) }},%20kami%20dari%20Admin%20Pusat%20U.N.O%20terkait%20laporan%20%23{{ $report->report_code }}." 
                               target="_blank" class="btn btn-outline-success btn-sm btn-block font-weight-bold rounded-pill shadow-sm">
                                <i class="fab fa-whatsapp mr-1"></i> Hubungi via WhatsApp
                            </a>
                        @endif
                    @else
                        <div class="text-muted text-xs">Pelapor anonim.</div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function setQuickMessage(text) {
    var ta = document.getElementById('adminReplyTextarea');
    if (ta) {
        ta.value = text;
        ta.focus();
    }
}
</script>
@endsection
