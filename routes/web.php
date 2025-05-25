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
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JadwalKuliahController;
use App\Http\Controllers\Admin\JadwalMatakuliahController;
use App\Http\Controllers\Admin\NilaiMahasiswaController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware([Authenticate::class, AdminMiddleware::class])->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('departemen', DepartemenController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('matakuliah', MatakuliahController::class);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('dosen', DosenController::class);
        Route::resource('jadwalkuliah', JadwalKuliahController::class);
        Route::resource('jadwalmatakuliah', JadwalMatakuliahController::class);
        Route::resource('nilaimahasiswa', NilaiMahasiswaController::class);
    });
});

Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware([Authenticate::class, MahasiswaMiddleware::class])->group(function () {
        Route::get('dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    });
});

Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::middleware([Authenticate::class, DosenMiddleware::class])->group(function () {
        Route::get('dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
    });
});

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
