@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Daftar Produk</h2>
            <p class="text-muted mb-0">Kelola produk sepatu</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-gradient">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                @if(auth()->user()->isAdmin())
                    <div class="col-md-4">
                        <select name="umkm_id" class="form-select">
                            <option value="">Semua UMKM</option>
                            @foreach($umkms as $umkm)
                                <option value="{{ $umkm->id }}" {{ request('umkm_id') == $umkm->id ? 'selected' : '' }}>
                                    {{ $umkm->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-4">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Products Grid -->
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
                            <p class="text-muted small mb-2">
                                <i class="bi bi-box me-1"></i>Stok: {{ $product->stok }}
                            </p>
                            @if($product->categories->count() > 0)
                                <div class="mb-2">
                                    @foreach($product->categories->take(2) as $category)
                                        <span class="badge badge-category">{{ $category->nama }}</span>
                                    @endforeach
                                    @if($product->categories->count() > 2)
                                        <span class="badge bg-secondary">+{{ $product->categories->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('update', $product)
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endcan
                                @can('delete', $product)
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
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
                <i class="bi bi-box-seam display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada produk</p>
                <a href="{{ route('products.create') }}" class="btn btn-gradient">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk Pertama
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
