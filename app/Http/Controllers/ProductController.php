<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Product::with(['umkm', 'categories', 'images']);
        
        // Filter by UMKM for non-admin
        if ($user->isUmkmOwner()) {
            $umkm = $user->umkm;
            if (!$umkm) {
                return redirect()->route('umkm.create')
                    ->with('info', 'Silakan buat profil UMKM Anda terlebih dahulu.');
            }
            $query->where('umkm_id', $umkm->id);
        }
        
        // Filter by UMKM (for admin)
        if ($request->filled('umkm_id') && $user->isAdmin()) {
            $query->where('umkm_id', $request->umkm_id);
        }
        
        // Filter by category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }
        
        $products = $query->latest()->paginate(12);
        $categories = Category::all();
        $umkms = $user->isAdmin() ? Umkm::all() : collect();
        
        return view('products.index', compact('products', 'categories', 'umkms'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $user = auth()->user();
        
        if ($user->isUmkmOwner() && !$user->umkm) {
            return redirect()->route('umkm.create')
                ->with('info', 'Silakan buat profil UMKM Anda terlebih dahulu.');
        }
        
        $categories = Category::all();
        $umkms = $user->isAdmin() ? Umkm::all() : collect([$user->umkm]);
        
        return view('products.create', compact('categories', 'umkms'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'ukuran' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'umkm_id' => 'required_if:is_admin,true|exists:umkms,id',
        ]);
        
        // Determine UMKM ID
        if ($user->isAdmin() && $request->filled('umkm_id')) {
            $umkmId = $request->umkm_id;
        } else {
            $umkmId = $user->umkm->id;
        }
        
        // Create product
        $product = Product::create([
            'umkm_id' => $umkmId,
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'ukuran' => $validated['ukuran'] ?? null,
            'warna' => $validated['warna'] ?? null,
        ]);
        
        // Attach categories
        if (!empty($validated['categories'])) {
            $product->categories()->attach($validated['categories']);
        }
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        
        $product->load(['umkm', 'categories', 'images']);
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        
        $user = auth()->user();
        $categories = Category::all();
        $umkms = $user->isAdmin() ? Umkm::all() : collect([$user->umkm]);
        
        $product->load(['categories', 'images']);
        
        return view('products.edit', compact('product', 'categories', 'umkms'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'ukuran' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
            'primary_image' => 'nullable|exists:product_images,id',
        ]);
        
        // Update product
        $product->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'ukuran' => $validated['ukuran'] ?? null,
            'warna' => $validated['warna'] ?? null,
        ]);
        
        // Sync categories
        $product->categories()->sync($validated['categories'] ?? []);
        
        // Delete selected images
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = ProductImage::whereIn('id', $validated['delete_images'])
                ->where('product_id', $product->id)
                ->get();
            
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
        
        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }
        
        // Set primary image
        if ($request->filled('primary_image')) {
            $product->images()->update(['is_primary' => false]);
            ProductImage::where('id', $request->primary_image)
                ->where('product_id', $product->id)
                ->update(['is_primary' => true]);
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        // Delete all product images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
