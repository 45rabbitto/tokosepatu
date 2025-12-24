@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-tags me-2"></i>Daftar Kategori</h2>
            <p class="text-muted mb-0">Kelola kategori produk</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-gradient">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <a href="{{ route('categories.show', $category) }}" class="fw-bold text-decoration-none">
                                            {{ $category->nama }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($category->deskripsi, 50) ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $category->products_count }} Produk</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-tags display-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada kategori</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-gradient">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
