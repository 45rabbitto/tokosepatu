<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UmkmOwnerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Admin can access everything
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        // UMKM owner must have an UMKM
        if (!auth()->user()->umkm) {
            return redirect()->route('umkm.create')
                ->with('info', 'Silakan buat profil UMKM Anda terlebih dahulu.');
        }

        return $next($request);
    }
}
