@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<!-- Hero Section -->
<div class="container-fluid px-0">
    <div class="position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 80vh;">
        <div class="container h-100">
            <div class="row align-items-center" style="min-height: 80vh;">
                <div class="col-lg-6 text-white">
                    <h1 class="display-4 fw-bold mb-4">
                        <i class="bi bi-shop me-2"></i>UMKM Sepatu
                    </h1>
                    <p class="lead mb-4">
                        Platform untuk membantu pendataan dan promosi UMKM serta toko sepatu. 
                        Temukan berbagai produk sepatu berkualitas dari UMKM lokal.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('search') }}" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-search me-2"></i>Cari Produk
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <i class="bi bi-shoe-heel text-white" style="font-size: 300px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Fitur Unggulan</h2>
        <p class="text-muted">Platform lengkap untuk pengelolaan UMKM dan toko sepatu</p>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-building text-white display-5"></i>
                    </div>
                    <h5 class="card-title fw-bold">Manajemen UMKM</h5>
                    <p class="card-text text-muted">
                        Kelola profil UMKM Anda dengan mudah. Tambahkan informasi lengkap tentang usaha Anda.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-box-seam text-white display-5"></i>
                    </div>
                    <h5 class="card-title fw-bold">Katalog Produk</h5>
                    <p class="card-text text-muted">
                        Upload dan kelola produk sepatu dengan foto, harga, dan deskripsi lengkap.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-search text-white display-5"></i>
                    </div>
                    <h5 class="card-title fw-bold">Pencarian Produk</h5>
                    <p class="card-text text-muted">
                        Temukan produk sepatu dengan mudah berdasarkan nama, kategori, atau UMKM.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-dark text-white py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3">Siap Memulai?</h3>
        <p class="mb-4">Daftarkan UMKM Anda sekarang dan mulai promosikan produk sepatu Anda!</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                <i class="bi bi-rocket-takeoff me-2"></i>Daftar Gratis
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5">
                <i class="bi bi-arrow-right me-2"></i>Ke Dashboard
            </a>
        @endguest
    </div>
</div>
@endsection
