@extends('layouts.app')

@section('title', $product->nama)

@section('content')
<div class="container">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    @if($product->images->count() > 0)
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ Storage::url($image->image_path) }}" class="d-block w-100 rounded" alt="{{ $product->nama }}" style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if($product->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            @endif
                        </div>
                        
                        @if($product->images->count() > 1)
                            <div class="row mt-3">
                                @foreach($product->images as $index => $image)
                                    <div class="col-3">
                                        <img src="{{ Storage::url($image->image_path) }}" class="img-thumbnail cursor-pointer" alt="Thumbnail" style="height: 80px; object-fit: cover; cursor: pointer;" onclick="document.querySelector('#productCarousel .carousel-item.active').classList.remove('active'); document.querySelectorAll('#productCarousel .carousel-item')[{{ $index }}].classList.add('active');">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                            <i class="bi bi-image text-white display-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('umkm.show', $product->umkm) }}">{{ $product->umkm->nama }}</a></li>
                            <li class="breadcrumb-item active">{{ $product->nama }}</li>
                        </ol>
                    </nav>
                    
                    <h2 class="fw-bold mb-3">{{ $product->nama }}</h2>
                    
                    @if($product->categories->count() > 0)
                        <div class="mb-3">
                            @foreach($product->categories as $category)
                                <a href="{{ route('categories.show', $category) }}" class="badge badge-category text-decoration-none">{{ $category->nama }}</a>
                            @endforeach
                        </div>
                    @endif
                    
                    <h3 class="text-primary fw-bold mb-4">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </h3>
                    
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-box-seam text-primary mb-2" style="font-size: 1.5rem;"></i>
                                <p class="mb-0 small text-muted">Stok</p>
                                <h5 class="mb-0">{{ $product->stok }}</h5>
                            </div>
                        </div>
                        @if($product->ukuran)
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <i class="bi bi-rulers text-primary mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0 small text-muted">Ukuran</p>
                                    <h5 class="mb-0">{{ $product->ukuran }}</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($product->warna)
                        <div class="mb-3">
                            <strong>Warna:</strong> {{ $product->warna }}
                        </div>
                    @endif
                    
                    @if($product->deskripsi)
                        <div class="mb-4">
                            <h5>Deskripsi Produk</h5>
                            <p class="text-muted">{{ $product->deskripsi }}</p>
                        </div>
                    @endif
                    
                    <!-- UMKM Info -->
                    <div class="border rounded p-3 mb-4">
                        <div class="d-flex align-items-center">
                            @if($product->umkm->logo)
                                <img src="{{ Storage::url($product->umkm->logo) }}" alt="{{ $product->umkm->nama }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-building text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $product->umkm->nama }}</h6>
                                <small class="text-muted">{{ $product->umkm->kontak }}</small>
                            </div>
                            <a href="{{ route('umkm.show', $product->umkm) }}" class="btn btn-sm btn-outline-primary ms-auto">
                                Lihat UMKM
                            </a>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        @can('update', $product)
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-gradient flex-grow-1">
                                <i class="bi bi-pencil me-1"></i> Edit Produk
                            </a>
                        @endcan
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
