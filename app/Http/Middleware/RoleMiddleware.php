<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Sistem Penghalang (Middleware) Keamanan Otorisasi.
     * Akan dijalankan dan dicek sebelum pengguna berhasil mengakses URL Admin Controller.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna mempunyai sesi Login yang sah di server
        if (!auth()->check()) {
            return redirect('login'); // Lempar ke form login
        }

        // 2. Cek apakah variabel Role pengguna di database ada dalam Array parameter route (contoh: "admin", "teknisi")
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request); // Jika cocok, teruskan request ke tujuan asli Controller
        }

        // 3. Jika Role tidak cocok, Blokir pengguna dan tampilkan Error akses 403 Forbidden
        abort(403, 'Unauthorized action.');
    }
}
