@extends('layouts.admin')

@section('title', 'Pesan Aduan Korban Penipuan (Messages)')
@section('page_title', 'Kotak Masuk Aduan Penipuan - Hubungi Korban & Tindak Pelaku')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Pusat</a></li>
    <li class="breadcrumb-item active">Pesan Masuk</li>
@endsection

@section('content')
<!-- Clean Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="font-weight-bold text-dark mb-1" style="letter-spacing: -0.5px;">Pusat Pesan Aduan & Laporan Keamanan</h4>
        <p class="text-muted text-sm mb-0">Kelola pesan korban penipuan transaksi, investigasi bukti, dan pembekuan akun pelaku.</p>
    </div>
    <div class="mt-2 mt-md-0">
        <a href="{{ route('admin.safety-reports.print', request()->all()) }}" target="_blank" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
            <i class="fas fa-print mr-1"></i> Cetak Berita Acara
        </a>
    </div>
</div>

<!-- 4 Modern Stat Cards -->
<div class="row mb-4">
    <!-- 1. Pesan Baru -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Pesan Baru</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $pendingCount }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #fee2e2; color: #dc2626;">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">Aduan Butuh Investigasi</span>
                <a href="{{ route('admin.messages.index', ['status' => 'pending']) }}" class="text-xs font-weight-bold text-danger">Filter Pesan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 2. Sedang Ditangani -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Sedang Ditangani</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $investigatingCount }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #fef3c7; color: #d97706;">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">Dalam Proses Chat</span>
                <a href="{{ route('admin.messages.index', ['status' => 'investigating']) }}" class="text-xs font-weight-bold text-warning">Filter &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 3. Akun Pelaku Dibekukan -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Pelaku Dibekukan</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $actionTakenCount }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #f1f5f9; color: #475569;">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">Sanksi Suspend</span>
                <a href="{{ route('admin.messages.index', ['status' => 'action_taken']) }}" class="text-xs font-weight-bold text-dark">Filter &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 4. Kasus Selesai -->
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="modern-stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Kasus Tuntas</span>
                    <h2 class="font-weight-bold text-dark mb-0 mt-1" style="font-size: 1.85rem;">{{ $resolvedCount }}</h2>
                </div>
                <div class="modern-stat-icon" style="background-color: #dcfce7; color: #16a34a;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="text-xs text-muted">Selesai / Damai</span>
                <a href="{{ route('admin.messages.index', ['status' => 'resolved']) }}" class="text-xs font-weight-bold text-success">Filter &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- Search & Status Filter Filter Bar -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-body p-3">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="row align-items-center">
            <div class="col-md-6 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0" style="border-radius: 8px 0 0 8px;"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" name="search" class="form-control border-left-0" style="border-radius: 0 8px 8px 0;" placeholder="Cari kode kasus, nama korban, nama penipu, atau pesan..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4 col-8 mb-2 mb-md-0">
                <select name="status" class="form-control" style="border-radius: 8px;" onchange="this.form.submit()">
                    <option value="">Semua Status Aduan</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pesan Baru (Investigasi)</option>
                    <option value="investigating" {{ request('status') == 'investigating' ? 'selected' : '' }}>💬 Sedang Ditangani</option>
                    <option value="action_taken" {{ request('status') == 'action_taken' ? 'selected' : '' }}>🚨 Pelaku Dibekukan</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>✅ Kasus Selesai</option>
                </select>
            </div>
            <div class="col-md-2 col-4 text-right">
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-block btn-sm" style="border-radius: 8px;">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Messages List Table -->
<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
        <h6 class="font-weight-bold text-dark mb-0">
            <i class="fas fa-inbox mr-2 text-danger"></i> Daftar Pesan Korban Penipuan
        </h6>
        <span class="badge badge-light border text-danger text-xs px-2 py-1">
            {{ $pendingCount }} Menunggu Respon
        </span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 140px;">Kode & Waktu</th>
                    <th>Pesan Korban & Kasus</th>
                    <th>Korban (Pelapor)</th>
                    <th>Terduga Penipu (Terlapor)</th>
                    <th style="width: 140px;" class="text-center">Status</th>
                    <th style="width: 130px;" class="text-center">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $r)
                <tr>
                    <td>
                        <span class="badge badge-dark font-weight-bold px-2 py-1">{{ $r->report_code }}</span>
                        <div class="text-muted text-xs mt-1"><i class="far fa-clock mr-1"></i> {{ $r->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td>
                        <div class="font-weight-bold text-dark text-sm mb-1">
                            {{ $r->title }}
                        </div>
                        <div class="text-muted text-xs mb-1" style="max-width: 320px; line-height: 1.4;">
                            "{{ Str::limit($r->description, 90) }}"
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
                            @if($r->booking)
                                <span class="badge badge-light border text-primary text-xs mr-1">
                                    <i class="fas fa-receipt mr-1"></i> Booking #{{ $r->booking->id }} ({{ $r->booking->item->name ?? 'Barang' }})
                                </span>
                            @endif
                            @if($r->evidence_photo)
                                <span class="badge badge-warning text-dark text-xs mr-1">
                                    <i class="fas fa-file-invoice-dollar mr-1"></i> Ada Bukti Transfer/Chat
                                </span>
                            @endif
                            @php
                                $msgCount = $r->messages->count();
                            @endphp
                            @if($msgCount > 0)
                                <span class="badge badge-info text-xs">
                                    <i class="fas fa-comments mr-1"></i> {{ $msgCount }} Pesan
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($r->reporter)
                        <div>
                            <span class="font-weight-bold text-dark text-sm">{{ $r->reporter->name }}</span>
                            <div class="text-muted text-xs"><i class="fas fa-envelope mr-1"></i> {{ $r->reporter->email }}</div>
                            <div class="text-muted text-xs"><i class="fab fa-whatsapp mr-1 text-success"></i> {{ $r->reporter->phone ?? '-' }}</div>
                        </div>
                        @else
                            <span class="text-muted text-sm">-</span>
                        @endif
                    </td>
                    <td>
                        @if($r->reportedUser)
                        <div>
                            <span class="font-weight-bold text-dark text-sm">{{ $r->reportedUser->name }}</span>
                            <div class="text-muted text-xs"><i class="fas fa-envelope mr-1"></i> {{ $r->reportedUser->email }}</div>
                            <div class="mt-1">
                                @if($r->reportedUser->status === 'suspended')
                                    <span class="badge badge-danger px-2 py-1 font-weight-bold text-xs">
                                        <i class="fas fa-user-slash mr-1"></i> DIBEKUKAN (SUSPEND)
                                    </span>
                                @else
                                    <span class="badge badge-success px-2 py-1 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i> Akun Masih Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        @else
                            <span class="text-muted text-sm">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $r->status_badge['class'] }} px-2 py-1 font-weight-bold text-xs">
                            <i class="{{ $r->status_badge['icon'] }} mr-1"></i> {{ $r->status_badge['label'] }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.messages.show', $r->id) }}" class="btn btn-sm btn-primary font-weight-bold px-3 py-1 shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-comments mr-1"></i> Buka Chat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-shield-alt fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="font-weight-bold text-dark">Tidak Ada Pesan Aduan Penipuan</h5>
                        <p class="text-muted text-sm mb-0">Kotak masuk aduan penipuan saat ini kosong. Tidak ada kasus penipuan sewa yang belum ditangani.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reports->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
        <div class="text-muted text-sm">
            Menampilkan {{ $reports->firstItem() }} s/d {{ $reports->lastItem() }} dari total {{ $reports->total() }} aduan penipuan.
        </div>
        <div>
            {{ $reports->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
