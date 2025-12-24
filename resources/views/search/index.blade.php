@extends('layouts.app')

@section('title', 'Cari Produk')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-0"><i class="bi bi-search me-2"></i>Cari Produk Sepatu</h2>
            <p class="text-muted">Temukan produk sepatu dari berbagai UMKM</p>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kata Kunci</label>
                        <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Nama produk, UMKM, atau kategori...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">UMKM</label>
                        <select name="umkm" class="form-select">
                            <option value="">Semua UMKM</option>
                            @foreach($umkms as $umkm)
                                <option value="{{ $umkm->id }}" {{ request('umkm') == $umkm->id ? 'selected' : '' }}>
                                    {{ $umkm->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Harga Min (Rp)</label>
                        <input type="number" class="form-control" name="min_price" value="{{ request('min_price') }}" placeholder="0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Harga Max (Rp)</label>
                        <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}" placeholder="999999">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-gradient">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('search') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Search Results -->
    @if(request()->hasAny(['q', 'category', 'umkm', 'min_price', 'max_price']))
        <div class="mb-3">
            <p class="text-muted">Ditemukan <strong>{{ $products->total() }}</strong> produk</p>
        </div>
    @endif
    
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
                            <p class="text-muted small mb-2">
                                <i class="bi bi-building me-1"></i>{{ $product->umkm->nama }}
                            </p>
                            <p class="text-primary fw-bold mb-2">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }}
                            </p>
                            @if($product->categories->count() > 0)
                                <div class="mb-2">
                                    @foreach($product->categories->take(2) as $category)
                                        <span class="badge badge-category">{{ $category->nama }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-search display-1 text-muted"></i>
                <p class="text-muted mt-3">
                    @if(request()->hasAny(['q', 'category', 'umkm', 'min_price', 'max_price']))
                        Tidak ada produk yang ditemukan dengan kriteria pencarian Anda
                    @else
                        Mulai pencarian dengan memasukkan kata kunci atau filter
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>
@endsection
