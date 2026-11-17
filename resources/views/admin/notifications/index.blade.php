@extends('layouts.admin')

@section('title', 'Notifikasi Sistem')
@section('page_title', 'Notifikasi Sistem & Broadcast')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Pengguna</a></li>
    <li class="breadcrumb-item active">Notifikasi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-danger shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-bell mr-1 text-danger"></i> Daftar Log Notifikasi ({{ $notifications->total() }})
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalBroadcast">
                        <i class="fas fa-bullhorn mr-1"></i> Kirim Broadcast Notifikasi
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Penerima</th>
                            <th>Judul Notifikasi</th>
                            <th>Pesan Lengkap</th>
                            <th>Tipe</th>
                            <th>Status Dibaca</th>
                            <th style="width: 140px;">Waktu Kirim</th>
                            <th style="width: 80px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notif)
                        <tr>
                            <td class="font-weight-bold text-muted">#{{ $notif->id }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $notif->user->name ?? 'User dihapus' }}</div>
                                <small class="text-muted">{{ $notif->user->email ?? '-' }}</small>
                            </td>
                            <td class="font-weight-semibold text-dark">{{ $notif->title }}</td>
                            <td>
                                <div class="text-muted text-sm" style="max-width: 320px;">{{ $notif->message }}</div>
                            </td>
                            <td>
                                <span class="badge badge-light border text-xs font-weight-bold">{{ $notif->type }}</span>
                            </td>
                            <td>
                                @if($notif->is_read)
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check-double mr-1"></i> Dibaca</span>
                                @else
                                    <span class="badge badge-warning px-2 py-1"><i class="fas fa-envelope mr-1"></i> Belum Dibaca</span>
                                @endif
                            </td>
                            <td class="text-xs text-muted">
                                {{ $notif->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="text-center">
                                <form id="del-notif-{{ $notif->id }}" action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDelete('del-notif-{{ $notif->id }}', 'Notifikasi #{{ $notif->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada notifikasi tersimpan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white clearfix">
                <div class="float-right">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Broadcast Notifikasi -->
<div class="modal fade" id="modalBroadcast" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-bullhorn mr-2"></i> Kirim Broadcast Notifikasi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-semibold">Target Penerima <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control" required>
                            <option value="all">📢 Semua Pengguna Aktif (Broadcast Publik)</option>
                            @foreach($users as $usr)
                                <option value="{{ $usr->id }}">{{ $usr->name }} ({{ $usr->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Judul Notifikasi <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Promo Diskon Sewa Akhir Pekan" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Kategori / Tipe Notifikasi</label>
                        <select name="type" class="form-control">
                            <option value="general">Informasi Umum (General)</option>
                            <option value="promo">Promo & Diskon</option>
                            <option value="maintenance">Pemberitahuan Sistem (Maintenance)</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-semibold">Isi Pesan Notifikasi <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Tuliskan isi pesan yang akan diterima di aplikasi mobile dan web..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-paper-plane mr-1"></i> Kirim Notifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
