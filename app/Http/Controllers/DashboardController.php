<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin sees all statistics
            $stats = [
                'total_umkm' => Umkm::count(),
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'recent_umkms' => Umkm::with('user')->latest()->take(5)->get(),
                'recent_products' => Product::with(['umkm', 'images'])->latest()->take(5)->get(),
            ];
            
            // Data for charts
            $chartData = [
                'umkm_monthly' => $this->getMonthlyUmkmData(),
                'products_by_category' => $this->getProductsByCategoryData(),
            ];
            
            return view('dashboard.admin', compact('stats', 'chartData'));
        } else {
            // UMKM owner sees their own data
            $umkm = $user->umkm;
            
            if (!$umkm) {
                return redirect()->route('umkm.create')
                    ->with('info', 'Silakan buat profil UMKM Anda terlebih dahulu.');
            }
            
            $stats = [
                'total_products' => $umkm->products()->count(),
                'products' => $umkm->products()->with(['categories', 'images'])->latest()->get(),
            ];
            
            return view('dashboard.umkm', compact('stats', 'umkm'));
        }
    }
    
    /**
     * Get monthly UMKM registration data for charts
     */
    private function getMonthlyUmkmData(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Umkm::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();
            $data[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        }
        return $data;
    }
    
    /**
     * Get products count by category for charts
     */
    private function getProductsByCategoryData(): array
    {
        return Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->nama,
                    'count' => $category->products_count,
                ];
            })
            ->toArray();
    }
}
