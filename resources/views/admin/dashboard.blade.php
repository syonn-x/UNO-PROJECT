@extends('layouts.admin')

@section('title', 'Dashboard Ringkas Admin Pusat')
@section('page_title', 'Dashboard Overview - Pusat Pengawasan & Pesan Penipuan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard Ringkas</li>
@endsection

@section('content')
<!-- Clean Greeting Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="font-weight-bold text-dark mb-1" style="letter-spacing: -0.5px;">Ringkasan Sistem</h4>
        <p class="text-muted text-sm mb-0">Pantau operasional platform rental UNO, penanganan aduan penipuan, dan data pengguna.</p>
    </div>
    <div class="mt-2 mt-md-0">
        <span class="badge badge-light border text-muted px-3 py-2 font-weight-normal" style="border-radius: 8px;">
            <i class="far fa-calendar-alt text-primary mr-1"></i> {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>
</div>

<!-- 4 Modern Stat Cards -->
<div class="row mb-4">
    <!-- 1. Pesan Penipuan Baru -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Pesan Penipuan</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $pendingSafetyReports }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #fee2e2; color: #dc2626;">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">{{ $totalSafetyReports }} Total Aduan</span>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-weight-bold text-danger">Buka Pesan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 2. Mitra Rental Terverifikasi -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Mitra Terverifikasi</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $totalOwners }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #dcfce7; color: #16a34a;">
                    <i class="fas fa-store"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">Pemilik Rental Aktif</span>
                <a href="{{ route('admin.users.index', ['owner_status' => 'approved']) }}" class="text-xs font-weight-bold text-success">Kelola Mitra &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 3. Total Pengguna -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Total Pengguna</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $totalUsers }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #e0f2fe; color: #0284c7;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">{{ $totalRenters }} Penyewa</span>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-weight-bold text-primary">Lihat User &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 4. Akun Dibekukan -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Akun Dibekukan</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $suspendedUsersCount }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #f1f5f9; color: #475569;">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">Sanksi Pelanggaran</span>
                <a href="{{ route('admin.users.index', ['status' => 'suspended']) }}" class="text-xs font-weight-bold text-dark">Lihat Suspend &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Row: Inbox Pesan Aduan Penipuan & Pengguna Terbaru -->
<div class="row">
    <!-- Left Column: Pesan Aduan Penipuan Masuk Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-envelope-open-text text-danger mr-2"></i> Aduan Korban Penipuan Terbaru
                </h6>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-xs btn-outline-danger font-weight-bold px-3 py-1" style="border-radius: 6px;">
                    Buka Kotak Masuk
                </a>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 120px;">Kode & Waktu</th>
                            <th>Judul Aduan Penipuan</th>
                            <th>Pihak Terkait</th>
                            <th style="width: 130px;" class="text-center">Status</th>
                            <th style="width: 110px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSafetyReports as $report)
                        <tr>
                            <td>
                                <span class="badge badge-dark font-weight-bold">{{ $report->report_code }}</span>
                                <div class="text-muted text-xs mt-1">{{ $report->created_at->format('d M, H:i') }}</div>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark text-sm mb-1 text-truncate" style="max-width: 250px;">
                                    {{ $report->title }}
                                </div>
                                <div class="text-muted text-xs text-truncate" style="max-width: 250px;">
                                    {{ Str::limit($report->description, 60) }}
                                </div>
                                @if($report->evidence_photo)
                                    <div class="mt-1">
                                        <span class="badge badge-light border text-danger text-xs"><i class="fas fa-paperclip mr-1"></i> Ada Bukti</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="text-xs">
                                    <span class="font-weight-semibold text-primary">Korban:</span> {{ $report->reporter->name ?? 'Anonim' }}
                                </div>
                                <div class="text-xs mt-1">
                                    <span class="font-weight-semibold text-danger">Terlapor:</span> {{ $report->reportedUser->name ?? '-' }}
                                    @if($report->reportedUser && $report->reportedUser->status === 'suspended')
                                        <span class="badge badge-danger text-xs ml-1">SUSPEND</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $report->status_badge['class'] }} px-2 py-1 text-xs font-weight-bold">
                                    {{ $report->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.messages.show', $report->id) }}" class="btn btn-xs btn-primary font-weight-bold px-2 py-1" style="border-radius: 6px;">
                                    Buka Chat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-check-circle text-success mr-1"></i> Tidak ada laporan penipuan baru. Platform berjalan aman.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Recent Users -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-user-plus text-primary mr-2"></i> Pengguna Baru Terdaftar
                </h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-xs btn-outline-primary font-weight-bold" style="border-radius: 6px;">Semua</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentUsers as $user)
                    <li class="list-group-item py-3 px-3 d-flex align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->avatar_url }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0284c7&color=fff';" class="rounded-circle mr-2 border" style="width: 36px; height: 36px; object-fit: cover;" alt="User">
                            <div>
                                <div class="font-weight-bold text-dark text-sm">{{ $user->name }}</div>
                                <div class="text-muted text-xs">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($user->is_owner)
                                <span class="badge badge-success text-xs"><i class="fas fa-store mr-1"></i> Mitra</span>
                            @else
                                <span class="badge badge-light border text-xs text-muted">Penyewa</span>
                            @endif
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-3 text-muted">Belum ada pengguna baru.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer text-center bg-white border-top py-2">
                <a href="{{ route('admin.users.index') }}" class="text-primary font-weight-semibold text-xs">
                    Kelola Seluruh Pengguna &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
