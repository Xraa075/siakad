<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
            } elseif ($role === 'dosen') {
                return redirect()->route('dosen.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
            }
            // Jika peran lain atau tidak terduga, bisa ke logout atau halaman umum
        }
        return redirect('/login')->with('error', 'Akses ditolak. Area khusus Admin.');
    }
}
