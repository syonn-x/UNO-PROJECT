@extends('layouts.admin')

@section('title', 'Data Pengguna & Verifikasi')
@section('page_title', 'Manajemen Pengguna & Verifikasi Keamanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Pusat</a></li>
    <li class="breadcrumb-item active">Data Pengguna</li>
@endsection

@section('content')
<!-- Top Action & Segmented Filter Tabs -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div class="modern-segmented-tab mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn {{ !request()->has('owner_status') && !request()->has('status') && !request()->has('role') ? 'active' : '' }}">
            <i class="fas fa-users mr-1"></i> Semua ({{ $users->total() }})
        </a>
        <a href="{{ route('admin.users.index', ['owner_status' => 'approved']) }}" class="btn {{ request('owner_status') === 'approved' ? 'active' : '' }}">
            <i class="fas fa-check-circle mr-1 text-success"></i> Mitra Terverifikasi ({{ $totalOwnersCount }})
        </a>
        <a href="{{ route('admin.users.index', ['status' => 'suspended']) }}" class="btn {{ request('status') === 'suspended' ? 'active' : '' }}">
            <i class="fas fa-user-slash mr-1 text-danger"></i> Dibekukan ({{ $suspendedCount }})
        </a>
    </div>
    <div>
        <button type="button" class="btn btn-primary font-weight-bold px-3 py-2 shadow-xs" data-toggle="modal" data-target="#modalAddUser" style="border-radius: 10px;">
            <i class="fas fa-plus mr-1"></i> Tambah Pengguna
        </button>
    </div>
</div>

<!-- Clean Search & Filter Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-body p-3">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row align-items-center">
            @if(request('owner_status'))
                <input type="hidden" name="owner_status" value="{{ request('owner_status') }}">
            @endif
            <div class="col-md-6 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0" style="border-radius: 8px 0 0 8px;"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" name="search" class="form-control border-left-0" style="border-radius: 0 8px 8px 0;" placeholder="Cari nama, email, no telepon, atau nama toko..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 col-6">
                <select name="role" class="form-control" style="border-radius: 8px;" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User (Penyewa / Mitra)</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Pusat</option>
                </select>
            </div>
            <div class="col-md-3 col-6">
                <select name="status" class="form-control" style="border-radius: 8px;" onchange="this.form.submit()">
                    <option value="">Semua Status Akun</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Users Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
        <h6 class="font-weight-bold text-dark mb-0">
            <i class="fas fa-users mr-2 text-primary"></i> Daftar Pengguna Platform
        </h6>
        <span class="text-xs text-muted">Total: {{ $users->total() }} Pengguna</span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 50px;">Foto</th>
                    <th>Nama Pengguna</th>
                    <th>Kontak</th>
                    <th>Tipe Akun</th>
                    <th style="width: 120px;">Role</th>
                    <th style="width: 130px;">Status Akun</th>
                    <th style="width: 80px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>
                        <img src="{{ $u->avatar_url }}" 
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=0284c7&color=fff';"
                             class="rounded-circle shadow-sm" style="width: 42px; height: 42px; object-fit: cover;" alt="user">
                    </td>
                    <td>
                        <div class="font-weight-bold text-dark">{{ $u->name }}</div>
                        <small class="text-muted">ID: #USR-{{ $u->id }} • Terdaftar {{ $u->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        <div><i class="fas fa-envelope text-xs text-muted mr-1"></i> {{ $u->email }}</div>
                        <small class="text-muted"><i class="fas fa-phone text-xs text-muted mr-1"></i> {{ $u->phone ?? 'Belum ada kontak' }}</small>
                    </td>
                    <td>
                        @if($u->is_owner || $u->owner_status === 'approved')
                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Mitra Terverifikasi</span>
                            @if($u->id_card_photo)
                                <a href="javascript:void(0)" class="badge badge-light border text-primary ml-1" data-toggle="modal" data-target="#modalKyc-{{ $u->id }}" title="Lihat Dokumen KTP">
                                    <i class="fas fa-id-card"></i> KTP
                                </a>
                            @endif
                            <div class="text-xs text-dark font-weight-bold mt-1">
                                {{ $u->owner_store_name ?? 'Rental Store' }}
                            </div>
                        @else
                            <span class="badge badge-light border text-muted px-2 py-1"><i class="fas fa-user mr-1"></i> Penyewa (Renter)</span>
                        @endif

                        <div class="text-xs text-muted mt-1">
                            <span class="mr-2"><i class="fas fa-boxes text-info mr-1"></i>{{ $u->items_count }} Unit</span>
                            <span><i class="fas fa-receipt text-success mr-1"></i>{{ $u->bookings_count }} Sewa</span>
                        </div>
                    </td>
                    <td>
                        <select class="form-control form-control-sm font-weight-bold rounded-pill text-xs border-0 {{ $u->role === 'admin' ? 'bg-danger text-white' : 'bg-light text-dark' }}" 
                                onchange="changeUserRole({{ $u->id }}, this.value, this)">
                            <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control form-control-sm font-weight-bold rounded-pill text-xs border-0" 
                                style="background-color: {{ $u->status === 'active' ? '#dcfce7' : ($u->status === 'suspended' ? '#fee2e2' : '#fef3c7') }}; color: {{ $u->status === 'suspended' ? '#b91c1c' : '#1e293b' }};"
                                onchange="changeUserStatus({{ $u->id }}, this.value, this)">
                            <option value="active" {{ $u->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $u->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ $u->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </td>
                    <td class="text-center">
                        @if($u->id !== auth()->id())
                        <form id="del-user-{{ $u->id }}" action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDelete('del-user-{{ $u->id }}', 'Pengguna {{ $u->name }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @else
                        <span class="badge badge-light text-muted">Akun Anda</span>
                        @endif
                    </td>
                </tr>

                <!-- Modal Dokumen KTP Mitra Terverifikasi -->
                @if($u->id_card_photo)
                <div class="modal fade" id="modalKyc-{{ $u->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title font-weight-bold">
                                    <i class="fas fa-id-card mr-2"></i> Dokumen KTP Mitra Terverifikasi
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                <div class="mb-3 text-center">
                                    <label class="font-weight-bold d-block text-dark">Foto KTP Mitra:</label>
                                    <img src="{{ $u->id_card_photo_url }}" onerror="this.onerror=null; this.src='https://placehold.co/600x380/e2e8f0/475569?text=Foto+KTP+Mitra';" class="img-fluid rounded border shadow-sm" style="max-height: 220px;" alt="KTP">
                                </div>

                                <div class="bg-light p-3 rounded border text-sm mb-3">
                                    <div><strong>Nama Lengkap:</strong> {{ $u->name }}</div>
                                    <div><strong>NIK KTP:</strong> <span class="badge badge-dark px-2 py-1">{{ $u->nik ?? 'Belum tercatat' }}</span></div>
                                    <div><strong>Email:</strong> {{ $u->email }}</div>
                                    <div><strong>Telepon:</strong> {{ $u->phone ?? '-' }}</div>
                                    <div><strong>Nama Toko Rental:</strong> {{ $u->owner_store_name ?? '-' }}</div>
                                    <div><strong>Alamat Toko:</strong> {{ $u->owner_address ?? '-' }}</div>
                                    <div><strong>Status:</strong> <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Terverifikasi Resmi</span></div>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-secondary font-weight-bold btn-sm" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-users-slash fa-3x text-muted mb-3 d-block"></i>
                        Tidak ada data pengguna yang sesuai dengan filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i> Tambah Pengguna Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="user@contoh.com">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" placeholder="08123456789">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Kata Sandi (Password) <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label class="font-weight-semibold">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="user" selected>User / Renter</option>
                                <option value="admin">Admin Pusat</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label class="font-weight-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeUserRole(id, newRole, selectElem) {
        updateResourceStatus('/admin/users/' + id + '/role', { role: newRole }, function(res) {
            selectElem.className = 'form-control form-control-sm font-weight-bold rounded-pill text-xs border-0 ' + 
                (newRole === 'admin' ? 'bg-danger text-white' : 'bg-light text-dark');
        });
    }

    function changeUserStatus(id, newStatus, selectElem) {
        updateResourceStatus('/admin/users/' + id + '/status', { status: newStatus }, function(res) {
            let colors = {
                'active': '#dcfce7',
                'inactive': '#fef3c7',
                'suspended': '#fee2e2'
            };
            selectElem.style.backgroundColor = colors[newStatus] || '#f1f5f9';
            selectElem.style.color = newStatus === 'suspended' ? '#b91c1c' : '#1e293b';
        });
    }
</script>
@endsection

