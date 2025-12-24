@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
            </h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total UMKM</h6>
                            <h2 class="fw-bold mb-0">{{ $stats['total_umkm'] }}</h2>
                        </div>
                        <i class="bi bi-building display-4 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('umkm.index') }}" class="text-white text-decoration-none">
                        Lihat semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card stat-card secondary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Produk</h6>
                            <h2 class="fw-bold mb-0">{{ $stats['total_products'] }}</h2>
                        </div>
                        <i class="bi bi-box-seam display-4 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('products.index') }}" class="text-white text-decoration-none">
                        Lihat semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Kategori</h6>
                            <h2 class="fw-bold mb-0">{{ $stats['total_categories'] }}</h2>
                        </div>
                        <i class="bi bi-tags display-4 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('categories.index') }}" class="text-white text-decoration-none">
                        Kelola <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Pendaftaran UMKM (6 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="umkmChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Produk per Kategori</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Data -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>UMKM Terbaru</h5>
                    <a href="{{ route('umkm.index') }}" class="btn btn-sm btn-gradient">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Pemilik</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_umkms'] as $umkm)
                                    <tr>
                                        <td>
                                            <a href="{{ route('umkm.show', $umkm) }}" class="text-decoration-none">
                                                {{ $umkm->nama }}
                                            </a>
                                        </td>
                                        <td>{{ $umkm->user->name }}</td>
                                        <td>{{ $umkm->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Belum ada UMKM terdaftar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-box me-2"></i>Produk Terbaru</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-gradient">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>UMKM</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_products'] as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                                {{ $product->nama }}
                                            </a>
                                        </td>
                                        <td>{{ $product->umkm->nama }}</td>
                                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Belum ada produk
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // UMKM Monthly Chart
    const umkmCtx = document.getElementById('umkmChart').getContext('2d');
    new Chart(umkmCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($chartData['umkm_monthly'], 'month')) !!},
            datasets: [{
                label: 'Jumlah UMKM',
                data: {!! json_encode(array_column($chartData['umkm_monthly'], 'count')) !!},
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
    
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_column($chartData['products_by_category'], 'name')) !!},
            datasets: [{
                data: {!! json_encode(array_column($chartData['products_by_category'], 'count')) !!},
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(17, 153, 142, 0.8)',
                    'rgba(242, 153, 74, 0.8)',
                    'rgba(245, 87, 108, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
