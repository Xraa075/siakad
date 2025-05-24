<?php

namespace App\Http\Controllers\Admin; // Namespace diubah ke Admin

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Dosen;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller // Nama class tetap, tapi namespace berubah
{
    /**
     * Display a listing of the resource.
     * Akan menampilkan kelas berdasarkan jurusan_id dari query parameter.
     */
    public function index(Request $request)
    {
        $jurusanId = $request->query('jurusan_id');
        $jurusanContext = null;
        // Eager load relasi yang dibutuhkan untuk tampilan index
        $kelasListQuery = Kelas::query()->with(['jurusan.departemen', 'dosenWali', 'jadwalKuliah']);

        if ($jurusanId) {
            $jurusanContext = Jurusan::with('departemen')->findOrFail($jurusanId);
            $kelasListQuery->where('jurusan_id', $jurusanId);
            $pageTitle = "Daftar Kelas untuk Jurusan: " . $jurusanContext->nama_jurusan;
        } else {
            // Jika diakses tanpa jurusan_id, arahkan kembali ke daftar jurusan untuk memilih konteks
            return redirect()->route('admin.jurusan.index')
                ->with('info', 'Silakan pilih jurusan terlebih dahulu untuk melihat daftar kelasnya.');
        }

        $kelasList = $kelasListQuery->orderBy('nama_kelas')->paginate(10); // Menggunakan variabel $kelasList

        return view('admin.kelas.index', compact('kelasList', 'jurusanContext', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     * Membutuhkan jurusan_id dari query parameter untuk konteks.
     */
    public function create(Request $request)
    {
        $jurusanId = $request->query('jurusan_id');
        if (!$jurusanId) {
            return redirect()->route('admin.jurusan.index') // atau admin.departemen.index
                ->with('error', 'Harap pilih jurusan terlebih dahulu untuk menambah kelas.');
        }

        $jurusanContext = Jurusan::with('departemen')->findOrFail($jurusanId);
        // Mengambil semua dosen (atau filter yang 'isDosenWali' jika ada flag tersebut di tabel dosen)
        $dosens = Dosen::orderBy('nama')->get(); // Anda bisa filter where('isDosenWali', true) jika perlu
        $jadwalKuliahs = JadwalKuliah::orderBy('nama_jadwal')->get(); // Mengganti nama variabel $jadwals

        return view('admin.kelas.create', compact('jurusanContext', 'dosens', 'jadwalKuliahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusans,id', // Ini akan dari hidden input
            'dosen_nip' => [ // dosen_nip adalah dosen wali
                'required',
                Rule::exists('dosens', 'nip') // Validasi sederhana, atau bisa tambahkan ->where('isDosenWali', true) jika perlu
            ],
            'semester' => 'required|integer|min:1',
            'jadwal_kuliah_id' => 'required|exists:jadwal_kuliahs,id',
        ]);

        Kelas::create($request->all());

        // Redirect kembali ke index kelas dengan menyertakan jurusan_id agar tetap dalam konteks
        return redirect()->route('admin.kelas.index', ['jurusan_id' => $request->jurusan_id])
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Opsional untuk alur admin, tapi bisa berguna)
     */
    public function show(Kelas $kela) // Menggunakan $kela karena nama model adalah Kelas
    {
        $kela->load(['jurusan.departemen', 'dosenWali', 'jadwalKuliah', 'mahasiswas']);
        return view('admin.kelas.show', compact('kela')); // Buat view admin.kelas.show jika perlu
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kela)
    {
        $kela->load('jurusan.departemen'); // Untuk konteks
        $jurusanContext = $kela->jurusan;
        $dosens = Dosen::orderBy('nama')->get(); // Atau filter dosen wali
        $jadwalKuliahs = JadwalKuliah::orderBy('nama_jadwal')->get();

        return view('admin.kelas.edit', compact('kela', 'jurusanContext', 'dosens', 'jadwalKuliahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusans,id', // Biasanya tidak diubah, tapi validasi tetap ada
            'dosen_nip' => 'required|exists:dosens,nip',
            'semester' => 'required|integer|min:1',
            'jadwal_kuliah_id' => 'required|exists:jadwal_kuliahs,id',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index', ['jurusan_id' => $kela->jurusan_id])
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kela)
    {
        // Tambahkan pengecekan jika ada mahasiswa di kelas tersebut sebelum menghapus
        if ($kela->mahasiswas()->exists()) {
            return redirect()->route('admin.kelas.index', ['jurusan_id' => $kela->jurusan_id])
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki mahasiswa terdaftar.');
        }

        $jurusanId = $kela->jurusan_id; // Simpan untuk redirect
        $kela->delete();

        return redirect()->route('admin.kelas.index', ['jurusan_id' => $jurusanId])
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
