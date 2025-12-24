<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search products
     */
    public function index(Request $request)
    {
        $query = Product::with(['umkm', 'categories', 'images']);
        
        // Search by keyword
        if ($request->filled('q')) {
            $query->search($request->q);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }
        
        // Filter by UMKM
        if ($request->filled('umkm')) {
            $query->where('umkm_id', $request->umkm);
        }
        
        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }
        
        $products = $query->latest()->paginate(12);
        $categories = Category::all();
        $umkms = Umkm::all();
        
        return view('search.index', compact('products', 'categories', 'umkms'));
    }
}
