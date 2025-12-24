@extends('layouts.app')

@section('title', 'Daftar UMKM')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-building me-2"></i>Daftar UMKM</h2>
            <p class="text-muted mb-0">Kelola data UMKM terdaftar</p>
        </div>
        @if(auth()->user()->isAdmin() || !auth()->user()->umkm)
            <a href="{{ route('umkm.create') }}" class="btn btn-gradient">
                <i class="bi bi-plus-lg me-1"></i> Tambah UMKM
            </a>
        @endif
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($umkms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Nama UMKM</th>
                                <th>Pemilik</th>
                                <th>Kontak</th>
                                <th>Jumlah Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($umkms as $umkm)
                                <tr>
                                    <td>
                                        @if($umkm->logo)
                                            <img src="{{ Storage::url($umkm->logo) }}" alt="{{ $umkm->nama }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-building text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('umkm.show', $umkm) }}" class="fw-bold text-decoration-none">
                                            {{ $umkm->nama }}
                                        </a>
                                    </td>
                                    <td>{{ $umkm->user->name ?? '-' }}</td>
                                    <td>{{ $umkm->kontak }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $umkm->products()->count() }} Produk</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('umkm.show', $umkm) }}" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('update', $umkm)
                                                <a href="{{ route('umkm.edit', $umkm) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $umkm)
                                                <form action="{{ route('umkm.destroy', $umkm) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus UMKM ini? Semua produk terkait juga akan dihapus.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $umkms->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-building display-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada UMKM terdaftar</p>
                    <a href="{{ route('umkm.create') }}" class="btn btn-gradient">
                        <i class="bi bi-plus-lg me-1"></i> Tambah UMKM Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
