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
use App\Http\Controllers\Mahasiswa\NilaiController as MahasiswaNilaiController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware([Authenticate::class, AdminMiddleware::class])->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('departemen', DepartemenController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('matakuliah', MatakuliahController::class);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('kelas', KelasController::class);
        Route::get('kelas/{id}/mahasiswa', [KelasController::class, 'showMahasiswa'])->name('kelas.mahasiswa');
        Route::resource('dosen', DosenController::class);
        Route::resource('jadwalkuliah', JadwalKuliahController::class);
        Route::resource('jadwalmatakuliah', JadwalMatakuliahController::class);
        Route::resource('nilaimahasiswa', NilaiMahasiswaController::class);
        Route::resource('/frs-mahasiswa', \App\Http\Controllers\Admin\FrsMahasiswaController::class);
    });
});

Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware([Authenticate::class, MahasiswaMiddleware::class])->group(function () {
        Route::get('dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/frs', [\App\Http\Controllers\Mahasiswa\FrsMahasiswaController::class, 'index'])->name('frs.index');
        Route::post('/frs/ambil/{id}', [\App\Http\Controllers\Mahasiswa\FrsMahasiswaController::class, 'ambil'])->name('frs.ambil');
        Route::get('/jadwal', [\App\Http\Controllers\Mahasiswa\JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('nilai', [MahasiswaNilaiController::class, 'index'])->name('nilai.index');
    });
});

Route::prefix('dosen')->name('dosen.')->group(function () {
    Route::middleware([Authenticate::class, DosenMiddleware::class])->group(function () {
        Route::get('dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/frs', [\App\Http\Controllers\Dosen\FrsMahasiswaController::class, 'index'])->name('frs.index');
        Route::post('/frs/{id}/acc', [\App\Http\Controllers\Dosen\FrsMahasiswaController::class, 'acc'])->name('frs.acc');
        Route::get('/jadwal', [\App\Http\Controllers\Dosen\JadwalDosenController::class, 'index'])->name('jadwal.index');
        Route::delete('/frs/{id}', [\App\Http\Controllers\Dosen\FrsMahasiswaController::class, 'destroy'])->name('frs.destroy');
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
