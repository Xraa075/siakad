<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        // Logika redirect setelah login berhasil
        $user = Auth::user(); // atau \Illuminate\Support\Facades\Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'mahasiswa') {
            return redirect()->intended(route('mahasiswa.dashboard'));
        } elseif ($user->role === 'dosen') {
            return redirect()->intended(route('dosen.dashboard'));
        }

        // Fallback jika tidak ada peran yang cocok atau untuk kasus umum
        // Jika RouteServiceProvider::HOME didefinisikan (di Laravel versi lama):
        // return redirect()->intended(RouteServiceProvider::HOME);
        // Atau fallback ke route spesifik:
        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
