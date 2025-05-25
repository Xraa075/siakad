<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DosenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role == 'dosen') {
            return $next($request);
        }
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Dosen.');
            } elseif ($role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Dosen.');
            }
        }
        return redirect('/login')->with('error', 'Akses ditolak. Area khusus Dosen.');
    }
}
