@extends('layouts.admin')

@section('title', 'Kelola Transaksi Booking')
@section('page_title', 'Transaksi & Sewa (Bookings)')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Kelola Booking</li>
@endsection

@section('content')
<!-- Filter Card -->
<div class="card card-outline card-info shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="row align-items-center">
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-xs text-muted mb-1 font-weight-bold">STATUS TRANSAKSI</label>
                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed (Dikonfirmasi)</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                </select>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-xs text-muted mb-1 font-weight-bold">TANGGAL MULAI SEWA</label>
                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="text-xs text-muted mb-1 font-weight-bold">TANGGAL AKHIR SEWA</label>
                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-3 text-md-right mt-3">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-undo mr-1"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark">
            <i class="fas fa-clipboard-list mr-1 text-info"></i> Daftar Booking Masuk ({{ $bookings->total() }})
        </h3>
        <span class="badge badge-light border">Update Status Cepat via AJAX</span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Order ID</th>
                    <th>Barang Rental</th>
                    <th>Penyewa (Renter)</th>
                    <th>Periode Sewa</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th style="width: 150px;">Status (AJAX)</th>
                    <th style="width: 120px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>
                        <span class="font-weight-bold text-dark">#BK-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <div class="text-xs text-muted">{{ $b->created_at->format('d/m H:i') }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $b->item->image_url }}" class="rounded mr-2" style="width: 44px; height: 44px; object-fit: cover;" alt="item">
                            <div>
                                <div class="font-weight-semibold text-dark">{{ $b->item->name }}</div>
                                <small class="text-muted">{{ $b->item->category->name }} • {{ $b->item->location }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-weight-medium">{{ $b->renter->name }}</div>
                        <small class="text-muted"><i class="fas fa-phone-alt text-xs mr-1"></i> {{ $b->renter->phone ?? 'Tidak ada no' }}</small>
                    </td>
                    <td>
                        <div class="font-weight-semibold text-dark">{{ \Carbon\Carbon::parse($b->start_date)->format('d M Y') }}</div>
                        <small class="text-muted">s/d {{ \Carbon\Carbon::parse($b->end_date)->format('d M Y') }}</small>
                    </td>
                    <td>
                        <span class="badge badge-light border font-weight-bold px-2 py-1">
                            {{ $b->total_days }} Hari
                        </span>
                    </td>
                    <td class="font-weight-bold text-primary">
                        Rp {{ number_format($b->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        <select class="form-control form-control-sm font-weight-bold text-xs rounded-pill border-0" 
                                style="background-color: {{ $b->status === 'completed' ? '#dcfce7' : ($b->status === 'confirmed' ? '#e0f2fe' : ($b->status === 'pending' ? '#fef3c7' : '#fee2e2')) }};"
                                onchange="changeBookingStatus({{ $b->id }}, this.value, this)">
                            <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </td>
                    <td class="text-center">
                        @if($b->notes)
                            <button type="button" class="btn btn-xs btn-outline-info mr-1" onclick="showNotes('{{ addslashes($b->notes) }}', '#BK-{{ $b->id }}')" title="Lihat Catatan">
                                <i class="fas fa-sticky-note"></i>
                            </button>
                        @endif
                        <form id="del-bk-{{ $b->id }}" action="{{ route('admin.bookings.destroy', $b->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDelete('del-bk-{{ $b->id }}', 'Booking #BK-{{ $b->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi booking sewa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeBookingStatus(id, newStatus, selectElem) {
        updateResourceStatus('/admin/bookings/' + id + '/status', { status: newStatus }, function(res) {
            let colors = {
                'completed': '#dcfce7',
                'confirmed': '#e0f2fe',
                'pending': '#fef3c7',
                'cancelled': '#fee2e2'
            };
            selectElem.style.backgroundColor = colors[newStatus] || '#f1f5f9';
        });
    }

    function showNotes(notes, orderId) {
        Swal.fire({
            title: 'Catatan Sewa ' + orderId,
            text: notes,
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    }
</script>
@endsection
