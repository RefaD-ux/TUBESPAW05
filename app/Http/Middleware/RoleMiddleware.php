<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();
        if ($user->role !== $role) {
            abort(403, "Akses ditolak. Role Anda adalah '{$user->role}', tetapi diperlukan '{$role}'.");
        }

        return $next($request);
    }
}
