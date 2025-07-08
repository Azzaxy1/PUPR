<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request, optionally requiring one or more roles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @param  mixed                     ...$roles  One or more role-slugs or titles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1) Pastikan user sudah login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2) Jika tidak ada role yang dipassing, lewati pengecekan
        if (empty($roles)) {
            return $next($request);
        }

        // 3) Ambil role user, normalisasi
        $userRole = strtolower(trim(Auth::user()->role->title));

        // 4) Normalisasi semua role yang diterima menjadi array lowercase
        $requiredRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        // 5) Log untuk debugging
        Log::info('RoleMiddleware: userRole=' . $userRole . ' requiredRoles=' . implode(',', $requiredRoles));

        // 6) Jika userRole ada di requiredRoles, izinkan
        if (in_array($userRole, $requiredRoles, true)) {
            return $next($request);
        }

        // 7) Jika tidak match, tolak akses
        abort(403, 'Akses ditolak.');
    }
}
