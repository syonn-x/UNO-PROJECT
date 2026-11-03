@extends('layouts.admin')

@section('title', 'Ulasan & Rating')
@section('page_title', 'Moderasi Ulasan & Rating (Reviews)')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Ulasan & Rating</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-star mr-1 text-warning"></i> Daftar Testimoni & Review Renter ({{ $reviews->total() }})
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Penyewa (User)</th>
                            <th>Barang Rental</th>
                            <th style="width: 140px;">Rating</th>
                            <th>Komentar Ulasan</th>
                            <th style="width: 120px;">Tanggal</th>
                            <th style="width: 80px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $rev)
                        <tr>
                            <td class="font-weight-bold text-muted">#{{ $rev->id }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $rev->user->name }}</div>
                                <small class="text-muted">{{ $rev->user->email }}</small>
                            </td>
                            <td>
                                <div class="font-weight-semibold text-primary">{{ $rev->item->name }}</div>
                                <small class="text-muted">Kategori: {{ $rev->item->category->name }}</small>
                            </td>
                            <td>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rev->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="font-weight-bold ml-1 text-dark">({{ $rev->rating }}.0)</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark" style="font-size: 0.9rem;">"{{ $rev->comment }}"</div>
                            </td>
                            <td class="text-muted text-xs">
                                {{ $rev->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="text-center">
                                <form id="del-rev-{{ $rev->id }}" action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDelete('del-rev-{{ $rev->id }}', 'Ulasan dari {{ $rev->user->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada ulasan yang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white clearfix">
                <div class="float-right">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
