<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Display a listing of UMKMs
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $umkms = Umkm::with('user')->latest()->paginate(10);
        } else {
            $umkms = Umkm::where('user_id', $user->id)->paginate(10);
        }
        
        return view('umkm.index', compact('umkms'));
    }

    /**
     * Show the form for creating a new UMKM
     */
    public function create()
    {
        // Check if UMKM owner already has an UMKM
        if (auth()->user()->isUmkmOwner() && auth()->user()->umkm) {
            return redirect()->route('umkm.edit', auth()->user()->umkm)
                ->with('info', 'Anda sudah memiliki UMKM. Silakan edit profil yang ada.');
        }
        
        return view('umkm.create');
    }

    /**
     * Store a newly created UMKM
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        // Check if UMKM owner already has an UMKM
        if (auth()->user()->isUmkmOwner() && auth()->user()->umkm) {
            return redirect()->route('umkm.index')
                ->with('error', 'Anda sudah memiliki UMKM.');
        }
        
        $validated['user_id'] = auth()->id();
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('umkm/logos', 'public');
        }
        
        Umkm::create($validated);
        
        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan!');
    }

    /**
     * Display the specified UMKM
     */
    public function show(Umkm $umkm)
    {
        $this->authorize('view', $umkm);
        
        $umkm->load(['products.images', 'products.categories', 'user']);
        
        return view('umkm.show', compact('umkm'));
    }

    /**
     * Show the form for editing the specified UMKM
     */
    public function edit(Umkm $umkm)
    {
        $this->authorize('update', $umkm);
        
        return view('umkm.edit', compact('umkm'));
    }

    /**
     * Update the specified UMKM
     */
    public function update(Request $request, Umkm $umkm)
    {
        $this->authorize('update', $umkm);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($umkm->logo) {
                Storage::disk('public')->delete($umkm->logo);
            }
            $validated['logo'] = $request->file('logo')->store('umkm/logos', 'public');
        }
        
        $umkm->update($validated);
        
        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil diperbarui!');
    }

    /**
     * Remove the specified UMKM
     */
    public function destroy(Umkm $umkm)
    {
        $this->authorize('delete', $umkm);
        
        // Delete logo
        if ($umkm->logo) {
            Storage::disk('public')->delete($umkm->logo);
        }
        
        // Products and related images will be deleted by cascade
        $umkm->delete();
        
        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil dihapus!');
    }
}
