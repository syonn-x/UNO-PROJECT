@extends('layouts.admin')

@section('title', 'Laporan Okupansi Barang')
@section('page_title', 'Laporan Okupansi & Pemanfaatan Barang Rental')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Okupansi Barang</li>
@endsection

@section('content')
<!-- Category Breakdown Cards -->
<div class="row">
    @foreach($categories as $cat)
    <div class="col-lg-2 col-md-4 col-6">
        <div class="card shadow-sm border text-center p-3 mb-3">
            <div class="text-xs text-muted font-weight-bold text-uppercase">{{ $cat->name }}</div>
            <div class="font-weight-bold text-primary mt-1" style="font-size: 1.4rem;">{{ $cat->items_count }}</div>
            <div class="text-xs text-muted">Unit Rental Aktif</div>
        </div>
    </div>
    @endforeach
</div>

<!-- Items Performance Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark">
            <i class="fas fa-chart-bar mr-1 text-primary"></i> Peringkat Kinerja & Pendapatan Tiap Barang Rental
        </h3>
        <span class="badge badge-light border">Berdasarkan Total Transaksi Sukses</span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 60px;">Foto</th>
                    <th>Nama Unit Rental</th>
                    <th>Kategori</th>
                    <th>Pemilik Unit</th>
                    <th>Tarif / Hari</th>
                    <th>Total Disewa</th>
                    <th class="text-right">Total Pendapatan Terkumpul</th>
                    <th style="width: 120px;" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $idx => $it)
                <tr>
                    <td>
                        <img src="{{ $it->image_url }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" alt="item">
                    </td>
                    <td>
                        <div class="font-weight-bold text-dark">{{ $it->name }}</div>
                        <small class="text-muted"><i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $it->location }}</small>
                    </td>
                    <td>
                        <span class="badge badge-light border font-weight-semibold">{{ $it->category->name }}</span>
                    </td>
                    <td>
                        <div class="font-weight-medium">{{ $it->owner->name }}</div>
                        <small class="text-muted">{{ $it->owner->phone ?? $it->owner->email }}</small>
                    </td>
                    <td class="font-weight-semibold text-muted">
                        Rp {{ number_format($it->price_per_day, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge badge-primary px-2 py-1 font-weight-bold">
                            {{ $it->total_rentals ?? 0 }}x Transaksi
                        </span>
                    </td>
                    <td class="text-right font-weight-bold text-success font-monospace" style="font-size: 0.95rem;">
                        Rp {{ number_format($it->total_earned ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($it->status === 'available')
                            <span class="badge badge-success px-2 py-1">Tersedia</span>
                        @elseif($it->status === 'unavailable')
                            <span class="badge badge-danger px-2 py-1">Tidak Tersedia</span>
                        @else
                            <span class="badge badge-secondary px-2 py-1">Hidden</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">Belum ada data barang rental.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
