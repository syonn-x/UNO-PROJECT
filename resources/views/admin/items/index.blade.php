@extends('layouts.admin')

@section('title', 'Data Barang Rental')
@section('page_title', 'Master Data Barang Rental (Items)')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Barang Rental</li>
@endsection

@section('content')
<!-- Filter & Action Card -->
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.items.index') }}" method="GET" class="row align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama barang atau lokasi..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <select name="category_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                    <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Disembunyikan</option>
                </select>
            </div>
            <div class="col-md-3 text-md-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddItem">
                    <i class="fas fa-plus mr-1"></i> Tambah Barang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Items Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark">
            <i class="fas fa-boxes mr-1 text-primary"></i> Katalog Unit Rental (<span id="total-unit-count">{{ $items->total() }}</span> unit)
        </h3>
        <span class="badge badge-light border">Update Status & Hapus via AJAX Instant</span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0" id="items-table">
            <thead>
                <tr>
                    <th style="width: 50px;">Foto</th>
                    <th>Nama Barang & Lokasi</th>
                    <th>Kategori</th>
                    <th>Pemilik (Owner)</th>
                    <th>Kondisi</th>
                    <th>Harga / Hari</th>
                    <th style="width: 140px;">Status (AJAX)</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr id="item-row-{{ $item->id }}">
                    <td>
                        <img src="{{ $item->image_url }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $item->name }}">
                    </td>
                    <td>
                        <div class="font-weight-bold text-dark">{{ $item->name }}</div>
                        <small class="text-muted"><i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $item->location }}</small>
                        @if($item->bookings_count > 0)
                            <div class="mt-1">
                                <span class="badge badge-light text-muted border text-xs" title="{{ $item->bookings_count }} transaksi terhubung">
                                    <i class="fas fa-history text-info mr-1"></i> {{ $item->bookings_count }} transaksi
                                </span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-light border px-2 py-1 font-weight-semibold">
                            {{ $item->category->name }}
                        </span>
                    </td>
                    <td>
                        <div class="font-weight-medium">{{ $item->owner->name }}</div>
                        <small class="text-muted">{{ $item->owner->phone ?? $item->owner->email }}</small>
                    </td>
                    <td>
                        @php
                            $condLabels = [
                                'new' => ['Baru', 'badge-success'],
                                'like_new' => ['Sangat Mulus', 'badge-info'],
                                'good' => ['Bagus', 'badge-primary'],
                                'fair' => ['Layak Pakai', 'badge-secondary']
                            ];
                            $c = $condLabels[$item->condition] ?? ['Normal', 'badge-secondary'];
                        @endphp
                        <span class="badge {{ $c[1] }} px-2 py-1">{{ $c[0] }}</span>
                    </td>
                    <td class="font-weight-bold text-primary">
                        Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                    </td>
                    <td>
                        <select class="form-control form-control-sm font-weight-bold rounded-pill border-0" 
                                style="background-color: {{ $item->status === 'available' ? '#dcfce7' : ($item->status === 'unavailable' ? '#fee2e2' : '#f1f5f9') }};"
                                onchange="changeItemStatus({{ $item->id }}, this.value, this)">
                            <option value="available" {{ $item->status === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ $item->status === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            <option value="hidden" {{ $item->status === 'hidden' ? 'selected' : '' }}>Hidden</option>
                        </select>
                    </td>
                    <td class="text-center text-nowrap">
                        <a href="{{ route('items.show', $item->id) }}" target="_blank" class="btn btn-xs btn-outline-info mr-1" title="Preview Halaman">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="btn btn-xs btn-outline-warning mr-1 btn-edit-item" 
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-category_id="{{ $item->category_id }}"
                                data-owner_id="{{ $item->owner_id }}"
                                data-price_per_day="{{ (int) $item->price_per_day }}"
                                data-condition="{{ $item->condition }}"
                                data-status="{{ $item->status }}"
                                data-location="{{ $item->location }}"
                                data-description="{{ $item->description }}"
                                title="Edit Barang">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form id="del-item-{{ $item->id }}" action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="btn btn-xs btn-outline-danger btn-delete-item" 
                                    data-id="{{ $item->id }}" 
                                    data-name="{{ $item->name }}" 
                                    data-action="{{ route('admin.items.destroy', $item->id) }}"
                                    title="Hapus Unit">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr id="empty-row">
                    <td colspan="8" class="text-center py-4 text-muted">Belum ada barang rental yang cocok dengan filter.</td>
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

<!-- Modal Tambah Barang Rental -->
<div class="modal fade" id="modalAddItem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.items.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-box-open mr-2"></i> Tambah Barang Rental Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Nama Barang Rental <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Kamera Sony A7 IV" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Pemilik / Owner <span class="text-danger">*</span></label>
                            <select name="owner_id" class="form-control" required>
                                @foreach($owners as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Harga Sewa Per Hari (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price_per_day" class="form-control" placeholder="150000" min="0" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-semibold">Kondisi Fisik <span class="text-danger">*</span></label>
                            <select name="condition" class="form-control" required>
                                <option value="new">Baru (New)</option>
                                <option value="like_new" selected>Sangat Mulus (Like New)</option>
                                <option value="good">Bagus (Good)</option>
                                <option value="fair">Layak Pakai (Fair)</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-semibold">Status Awal <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="available" selected>Tersedia (Available)</option>
                                <option value="unavailable">Tidak Tersedia</option>
                                <option value="hidden">Disembunyikan</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-semibold">Lokasi Unit <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control" placeholder="Jakarta Selatan" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="font-weight-semibold">URL Foto Utama</label>
                            <input type="url" name="image_url" class="form-control" placeholder="https://images.unsplash.com/...">
                            <small class="text-muted">Masukkan link URL gambar atau kosongkan untuk gambar default.</small>
                        </div>
                        <div class="col-md-12 form-group mb-0">
                            <label class="font-weight-semibold">Deskripsi & Kelengkapan <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan spesifikasi, kelengkapan aksesoris, dan ketentuan sewa..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Barang Rental -->
<div class="modal fade" id="modalEditItem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formEditItem" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit Data Barang Rental</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Nama Barang Rental <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" id="edit_category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Pemilik / Owner <span class="text-danger">*</span></label>
                            <select name="owner_id" id="edit_owner_id" class="form-control" required>
                                @foreach($owners as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-semibold">Harga Sewa Per Hari (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price_per_day" id="edit_price_per_day" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-semibold">Kondisi Fisik <span class="text-danger">*</span></label>
                            <select name="condition" id="edit_condition" class="form-control" required>
                                <option value="new">Baru (New)</option>
                                <option value="like_new">Sangat Mulus (Like New)</option>
                                <option value="good">Bagus (Good)</option>
                                <option value="fair">Layak Pakai (Fair)</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="available">Tersedia (Available)</option>
                                <option value="unavailable">Tidak Tersedia</option>
                                <option value="hidden">Disembunyikan</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-semibold">Lokasi Unit <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="edit_location" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group mb-0">
                            <label class="font-weight-semibold">Deskripsi & Kelengkapan <span class="text-danger">*</span></label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Perbarui Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeItemStatus(id, newStatus, selectElem) {
        updateResourceStatus('/admin/items/' + id + '/status', { status: newStatus }, function(res) {
            let colors = {
                'available': '#dcfce7',
                'unavailable': '#fee2e2',
                'hidden': '#f1f5f9'
            };
            selectElem.style.backgroundColor = colors[newStatus] || '#f1f5f9';
        });
    }

    $(document).ready(function() {
        // Edit Item Modal Handler
        $(document).on('click', '.btn-edit-item', function() {
            const btn = $(this);
            const id = btn.data('id');
            $('#formEditItem').attr('action', '/admin/items/' + id);
            $('#edit_name').val(btn.data('name'));
            $('#edit_category_id').val(btn.data('category_id'));
            $('#edit_owner_id').val(btn.data('owner_id'));
            $('#edit_price_per_day').val(btn.data('price_per_day'));
            $('#edit_condition').val(btn.data('condition'));
            $('#edit_status').val(btn.data('status'));
            $('#edit_location').val(btn.data('location'));
            $('#edit_description').val(btn.data('description'));
            $('#modalEditItem').modal('show');
        });

        // Delete Item Handler with SweetAlert2 & AJAX
        $(document).on('click', '.btn-delete-item', function(e) {
            e.preventDefault();
            const btn = $(this);
            const itemId = btn.data('id');
            const itemName = btn.data('name') || 'unit ini';
            const actionUrl = btn.data('action');
            const formId = 'del-item-' + itemId;

            Swal.fire({
                title: 'Hapus Barang Rental?',
                html: 'Apakah Anda yakin ingin menghapus <strong>' + $('<div>').text(itemName).html() + '</strong>?<br><small class="text-muted">Seluruh jadwal availability, foto, dan histori terkait unit ini akan dibersihkan.</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus Sekarang!',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        headers: {
                            'Accept': 'application/json'
                        }
                    }).then(response => {
                        return response;
                    }).catch(error => {
                        let errorMsg = 'Gagal menghapus barang rental.';
                        if (error.responseJSON && error.responseJSON.message) {
                            errorMsg = error.responseJSON.message;
                        }
                        Swal.showValidationMessage(errorMsg);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value && result.value.success) {
                    Toast.fire({
                        icon: 'success',
                        title: result.value.message || 'Barang rental berhasil dihapus!'
                    });

                    // Remove table row with animation
                    const row = $('#item-row-' + itemId);
                    row.fadeOut(350, function() {
                        $(this).remove();

                        // Decrement unit counter
                        const totalElem = $('#total-unit-count');
                        if (totalElem.length) {
                            let curCount = parseInt(totalElem.text()) || 0;
                            if (curCount > 0) {
                                totalElem.text(curCount - 1);
                            }
                        }

                        // If table is now empty
                        if ($('#items-table tbody tr').length === 0) {
                            $('#items-table tbody').html(
                                '<tr id="empty-row"><td colspan="8" class="text-center py-4 text-muted">Belum ada barang rental yang cocok dengan filter.</td></tr>'
                            );
                        }
                    });
                } else if (result.isConfirmed && !result.value) {
                    // Fallback to standard form submission if AJAX didn't return json
                    const form = document.getElementById(formId);
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    });
</script>
@endsection
