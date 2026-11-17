@extends('layouts.admin')

@section('title', 'Laporan Transaksi & Omset')
@section('page_title', 'Laporan Transaksi & Pendapatan Sewa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Transaksi & Omset</li>
@endsection

@section('content')
<!-- Filter Period & Category Card -->
<div class="card card-outline card-success shadow-sm mb-4">
    <div class="card-header bg-white">
        <h3 class="card-title font-weight-bold text-dark">
            <i class="fas fa-filter mr-1 text-success"></i> Parameter Filter Laporan Keuangan
        </h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="row align-items-end">
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-xs text-muted font-weight-bold mb-1">DARI TANGGAL</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-xs text-muted font-weight-bold mb-1">SAMPAI TANGGAL</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <label class="text-xs text-muted font-weight-bold mb-1">STATUS SEWA</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>Confirmed (Aktif)</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <label class="text-xs text-muted font-weight-bold mb-1">KATEGORI</label>
                <select name="category_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $categoryId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-success flex-grow-1 mr-1 font-weight-bold">
                    <i class="fas fa-search mr-1"></i> Terapkan
                </button>
                <a href="{{ route('admin.reports.print', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}" target="_blank" class="btn btn-outline-dark" title="Cetak Laporan">
                    <i class="fas fa-print"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Financial Summary KPIs -->
<div class="row">
    <div class="col-md-3 col-6">
        <div class="info-box shadow-sm border">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Total Omset Bersih</span>
                <span class="info-box-number font-weight-bold text-success" style="font-size: 1.25rem;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="info-box shadow-sm border">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Total Transaksi</span>
                <span class="info-box-number font-weight-bold" style="font-size: 1.25rem;">
                    {{ $totalTransactions }} Pesanan
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="info-box shadow-sm border">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-day"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Total Hari Tersewa</span>
                <span class="info-box-number font-weight-bold" style="font-size: 1.25rem;">
                    {{ $totalRentalDays }} Hari
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="info-box shadow-sm border">
            <span class="info-box-icon bg-warning elevation-1 text-white"><i class="fas fa-chart-line"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Rata-rata Nilai Sewa</span>
                <span class="info-box-number font-weight-bold text-dark" style="font-size: 1.25rem;">
                    Rp {{ number_format($averageOrderValue, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Table Card -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark">
            <i class="fas fa-table mr-1 text-success"></i> Rincian Transaksi Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </h3>
        <a href="{{ route('admin.reports.print', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}" target="_blank" class="btn btn-sm btn-outline-success font-weight-bold">
            <i class="fas fa-print mr-1"></i> Cetak Dokumen / PDF
        </a>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No. Order</th>
                    <th>Tanggal</th>
                    <th>Barang Rental</th>
                    <th>Kategori</th>
                    <th>Penyewa</th>
                    <th>Durasi Sewa</th>
                    <th>Tarif / Hari</th>
                    <th class="text-right">Total Transaksi</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td class="font-weight-bold text-dark">#BK-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-muted">{{ $b->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="font-weight-semibold text-dark">{{ $b->item->name }}</div>
                        <small class="text-muted">{{ $b->item->location }}</small>
                    </td>
                    <td>
                        <span class="badge badge-light border">{{ $b->item->category->name }}</span>
                    </td>
                    <td>
                        <div class="font-weight-medium">{{ $b->renter->name }}</div>
                        <small class="text-muted">{{ $b->renter->phone ?? $b->renter->email }}</small>
                    </td>
                    <td>
                        <span class="badge badge-light border font-weight-bold">{{ $b->total_days }} Hari</span>
                        <div class="text-xs text-muted">{{ \Carbon\Carbon::parse($b->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($b->end_date)->format('d/m/Y') }}</div>
                    </td>
                    <td class="text-muted">
                        Rp {{ number_format($b->item->price_per_day, 0, ',', '.') }}
                    </td>
                    <td class="text-right font-weight-bold text-success font-monospace" style="font-size: 0.95rem;">
                        Rp {{ number_format($b->total_price, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($b->status === 'completed')
                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Selesai</span>
                        @elseif($b->status === 'confirmed')
                            <span class="badge badge-info px-2 py-1"><i class="fas fa-sync-alt mr-1"></i> Dikonfirmasi</span>
                        @elseif($b->status === 'pending')
                            <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> Pending</span>
                        @else
                            <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Batal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">Tidak ada transaksi ditemukan pada periode filter ini.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-light font-weight-bold">
                    <td colspan="7" class="text-right uppercase">Total Omset Terfilter:</td>
                    <td class="text-right text-success" style="font-size: 1.1rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
