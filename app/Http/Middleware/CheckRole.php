<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            // ✅ Teks custom berdasarkan role
            $roleText = match ($role) {
                'admin' => 'el atmin los wemos arduinos',
                'user' => 'pengguna biasa los wemos',
                default => strtoupper($role)
            };

            abort(403, "Akses ditolak, Anda bukan $roleText");
        }

        return $next($request);
    }
}
