@extends('layouts.admin')

@section('title', 'Kategori Barang')
@section('page_title', 'Master Data Kategori')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Master Data</a></li>
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-tags mr-1 text-primary"></i> Daftar Kategori Barang Rental
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddCategory">
                        <i class="fas fa-plus mr-1"></i> Tambah Kategori
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th style="width: 140px;">Jumlah Barang</th>
                            <th style="width: 150px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td class="font-weight-bold text-muted">#{{ $cat->id }}</td>
                            <td class="font-weight-bold text-dark">
                                <i class="fas fa-folder text-warning mr-2"></i> {{ $cat->name }}
                            </td>
                            <td class="text-muted">{{ $cat->description ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info px-2 py-1 font-weight-semibold">
                                    {{ $cat->items_count }} Barang
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-xs btn-outline-warning mr-1" 
                                        onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description ?? '') }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form id="del-cat-{{ $cat->id }}" action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDelete('del-cat-{{ $cat->id }}', 'Kategori {{ $cat->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix bg-white">
                <div class="float-right">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i> Tambah Kategori Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Drone & Aerial" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat mengenai jenis barang..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formEditCategory" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="edit_cat_name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold">Deskripsi</label>
                        <textarea id="edit_cat_desc" name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-check mr-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editCategory(id, name, desc) {
        document.getElementById('formEditCategory').action = '/admin/categories/' + id;
        document.getElementById('edit_cat_name').value = name;
        document.getElementById('edit_cat_desc').value = desc;
        $('#modalEditCategory').modal('show');
    }
</script>
@endsection
