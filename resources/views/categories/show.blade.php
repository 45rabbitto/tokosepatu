@extends('layouts.app')

@section('title', $category->nama)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-tag me-2"></i>{{ $category->nama }}</h2>
            <p class="text-muted mb-0">{{ $category->deskripsi ?? 'Tidak ada deskripsi' }}</p>
        </div>
        <div>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produk dalam Kategori {{ $category->nama }}</h5>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card product-card h-100">
                                @if($product->images->count() > 0)
                                    <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->nama }}" class="card-img-top">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px; border-radius: 15px 15px 0 0;">
                                        <i class="bi bi-image text-white display-4"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title fw-bold mb-1">{{ $product->nama }}</h6>
                                    <p class="text-muted small mb-2">{{ $product->umkm->nama }}</p>
                                    <p class="text-primary fw-bold mb-2">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </p>
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
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada produk dalam kategori ini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
