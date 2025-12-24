@extends('layouts.app')

@section('title', $umkm->nama)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($umkm->logo)
                        <img src="{{ Storage::url($umkm->logo) }}" alt="{{ $umkm->nama }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                            <i class="bi bi-building text-white display-3"></i>
                        </div>
                    @endif
                    <h3 class="fw-bold">{{ $umkm->nama }}</h3>
                    <p class="text-muted">{{ $umkm->deskripsi ?? 'Belum ada deskripsi' }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="bi bi-person me-2"></i> <strong>Pemilik:</strong> {{ $umkm->user->name ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-geo-alt me-2"></i> <strong>Alamat:</strong> {{ $umkm->alamat }}
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-telephone me-2"></i> <strong>Kontak:</strong> {{ $umkm->kontak }}
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-box-seam me-2"></i> <strong>Produk:</strong> {{ $umkm->products->count() }} produk
                    </li>
                </ul>
                <div class="card-footer bg-transparent">
                    @can('update', $umkm)
                        <a href="{{ route('umkm.edit', $umkm) }}" class="btn btn-gradient w-100 mb-2">
                            <i class="bi bi-pencil me-1"></i> Edit UMKM
                        </a>
                    @endcan
                    <a href="{{ route('umkm.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produk dari {{ $umkm->nama }}</h5>
                    @can('update', $umkm)
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-gradient">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    @if($umkm->products->count() > 0)
                        <div class="row">
                            @foreach($umkm->products as $product)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card product-card h-100">
                                        @if($product->images->count() > 0)
                                            <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->nama }}" class="card-img-top">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <i class="bi bi-image text-white display-4"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold">{{ $product->nama }}</h6>
                                            <p class="text-primary fw-bold mb-1">
                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </p>
                                            <small class="text-muted">Stok: {{ $product->stok }}</small>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary w-100">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam display-1 text-muted"></i>
                            <p class="text-muted mt-3">UMKM ini belum memiliki produk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
