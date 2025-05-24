<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MahasiswaMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\MatakuliahController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\KelasController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Middleware Authenticate akan memastikan user sudah login.
    // AdminMiddleware akan memastikan user yang login memiliki peran 'admin'.
    Route::middleware([Authenticate::class, AdminMiddleware::class])->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('departemen', DepartemenController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('matakuliah', MatakuliahController::class);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('kelas', KelasController::class);
        // Tambahkan rute admin lainnya di sini
    });
});

Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware([Authenticate::class, MahasiswaMiddleware::class])->group(function () {
        Route::get('dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        // Tambahkan rute mahasiswa lainnya di sini
    });
});

Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::middleware([Authenticate::class, DosenMiddleware::class])->group(function () {
        Route::get('dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        // Tambahkan rute dosen lainnya di sini
    });
});

// Pastikan rute login dan logout dari Breeze berfungsi
// Contoh (mungkin sudah ada atau dikonfigurasi oleh Breeze):
// Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::post('login', [AuthenticatedSessionController::class, 'store']);
// Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
