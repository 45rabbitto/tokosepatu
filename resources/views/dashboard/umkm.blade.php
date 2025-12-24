@extends('layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard {{ $umkm->nama }}
            </h2>
            <p class="text-muted">Kelola UMKM dan produk Anda</p>
        </div>
    </div>
    
    <!-- UMKM Profile Card -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    @if($umkm->logo)
                        <img src="{{ Storage::url($umkm->logo) }}" alt="{{ $umkm->nama }}" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                            <i class="bi bi-building text-white display-4"></i>
                        </div>
                    @endif
                    <h4 class="fw-bold">{{ $umkm->nama }}</h4>
                    <p class="text-muted mb-3">{{ $umkm->deskripsi ?? 'Belum ada deskripsi' }}</p>
                    <a href="{{ route('umkm.edit', $umkm) }}" class="btn btn-gradient">
                        <i class="bi bi-pencil me-1"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Produk</h6>
                                    <h2 class="fw-bold mb-0">{{ $stats['total_products'] }}</h2>
                                </div>
                                <i class="bi bi-box-seam display-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card stat-card secondary h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Kontak</h6>
                                    <h5 class="fw-bold mb-0">{{ $umkm->kontak }}</h5>
                                </div>
                                <i class="bi bi-telephone display-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-2"><i class="bi bi-geo-alt me-1"></i> Alamat</h6>
                            <p class="mb-0">{{ $umkm->alamat }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produk Saya</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-gradient">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                    </a>
                </div>
                <div class="card-body">
                    @if($stats['products']->count() > 0)
                        <div class="row">
                            @foreach($stats['products'] as $product)
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="card product-card h-100">
                                        @if($product->images->count() > 0)
                                            <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->nama }}" class="card-img-top">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="bi bi-image text-white display-4"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold">{{ $product->nama }}</h6>
                                            <p class="text-primary fw-bold mb-2">
                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </p>
                                            <p class="text-muted small mb-2">Stok: {{ $product->stok }}</p>
                                            @if($product->categories->count() > 0)
                                                <div class="mb-2">
                                                    @foreach($product->categories->take(2) as $category)
                                                        <span class="badge badge-category">{{ $category->nama }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="btn-group w-100">
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam display-1 text-muted"></i>
                            <p class="text-muted mt-3">Belum ada produk</p>
                            <a href="{{ route('products.create') }}" class="btn btn-gradient">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Produk Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
