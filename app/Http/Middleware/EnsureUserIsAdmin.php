<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'))->with('error', 'Silakan login terlebih dahulu untuk mengakses panel admin.');
        }

        $user = Auth::user();

        // Check if account is suspended
        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator.');
        }

        // Check if user role is admin
        if ($user->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak! Anda tidak memiliki hak akses administrator.');
        }

        return $next($request);
    }
}
