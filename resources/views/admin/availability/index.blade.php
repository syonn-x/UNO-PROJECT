@extends('layouts.admin')

@section('title', 'Jadwal Ketersediaan')
@section('page_title', 'Kalender & Jadwal Ketersediaan (Availability)')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Jadwal Ketersediaan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-calendar-check mr-1 text-success"></i> Pengaturan Jadwal Slot Barang Rental
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAddAvail">
                        <i class="fas fa-plus mr-1"></i> Atur Jadwal / Blokir Tanggal
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Barang Rental</th>
                            <th>Kategori</th>
                            <th>Mulai Tanggal</th>
                            <th>Sampai Tanggal</th>
                            <th>Status Slot</th>
                            <th style="width: 100px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availabilities as $av)
                        <tr>
                            <td class="font-weight-bold text-muted">#{{ $av->id }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $av->item->name }}</div>
                                <small class="text-muted">{{ $av->item->location }}</small>
                            </td>
                            <td>
                                <span class="badge badge-light border">{{ $av->item->category->name }}</span>
                            </td>
                            <td class="font-weight-semibold">
                                {{ \Carbon\Carbon::parse($av->start_date)->format('d M Y') }}
                            </td>
                            <td class="font-weight-semibold">
                                {{ \Carbon\Carbon::parse($av->end_date)->format('d M Y') }}
                            </td>
                            <td>
                                @if($av->status === 'available')
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Available</span>
                                @elseif($av->status === 'booked')
                                    <span class="badge badge-primary px-2 py-1"><i class="fas fa-shopping-cart mr-1"></i> Booked</span>
                                @else
                                    <span class="badge badge-danger px-2 py-1"><i class="fas fa-ban mr-1"></i> Blocked (Maintenance)</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form id="del-av-{{ $av->id }}" action="{{ route('admin.availability.destroy', $av->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDelete('del-av-{{ $av->id }}', 'Jadwal #{{ $av->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada pengaturan jadwal slot.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white clearfix">
                <div class="float-right">
                    {{ $availabilities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Atur Ketersediaan -->
<div class="modal fade" id="modalAddAvail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.availability.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-calendar-plus mr-2"></i> Tambah Slot Ketersediaan / Blokir Tanggal</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-semibold">Pilih Barang Rental <span class="text-danger">*</span></label>
                        <select name="item_id" class="form-control" required>
                            @foreach($items as $it)
                                <option value="{{ $it->id }}">{{ $it->name }} ({{ $it->location }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Tanggal Berakhir <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Status Slot <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="available" selected>Available (Tersedia untuk disewa)</option>
                            <option value="booked">Booked (Sudah dipesan)</option>
                            <option value="blocked">Blocked (Sedang diservis/maintenance)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-save mr-1"></i> Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
