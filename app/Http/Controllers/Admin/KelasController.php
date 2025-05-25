<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Dosen;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $jurusanId = $request->query('jurusan_id');
        $jurusanContext = null;
        $kelasListQuery = Kelas::query()->with(['jurusan.departemen', 'dosenWali', 'jadwalKuliah']);

        if ($jurusanId) {
            $jurusanContext = Jurusan::with('departemen')->findOrFail($jurusanId);
            $kelasListQuery->where('jurusan_id', $jurusanId);
            $pageTitle = "Daftar Kelas untuk Jurusan: " . $jurusanContext->nama_jurusan;
        } else {
            return redirect()->route('admin.jurusan.index')
                ->with('info', 'Silakan pilih jurusan terlebih dahulu untuk melihat daftar kelasnya.');
        }

        $kelasList = $kelasListQuery->orderBy('nama_kelas')->paginate(10);

        return view('admin.kelas.index', compact('kelasList', 'jurusanContext', 'pageTitle'));
    }

    public function create(Request $request)
    {
        $jurusanId = $request->query('jurusan_id');
        if (!$jurusanId) {
            return redirect()->route('admin.jurusan.index')
                ->with('error', 'Harap pilih jurusan terlebih dahulu untuk menambah kelas.');
        }

        $jurusanContext = Jurusan::with('departemen')->findOrFail($jurusanId);
        $dosens = Dosen::where('isDosenWali', true)->get();
        $jadwalKuliahs = JadwalKuliah::orderBy('nama_jadwal')->get();

        return view('admin.kelas.create', compact('jurusanContext', 'dosens', 'jadwalKuliahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusans,id',
            'dosen_nip' => [
                'required',
                Rule::exists('dosens', 'nip')->where('isDosenWali', true)
            ],
            'semester' => 'required|integer|min:1',
            'jadwal_kuliah_id' => 'required|exists:jadwal_kuliahs,id',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index', ['jurusan_id' => $request->jurusan_id])
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kela)
    {
        $kela->load(['jurusan.departemen', 'dosenWali', 'jadwalKuliah', 'mahasiswas']);
        return view('admin.kelas.show', compact('kela'));
    }

    public function edit(Kelas $kela)
    {
        $kela->load('jurusan.departemen');
        $jurusanContext = $kela->jurusan;
        $dosens = Dosen::where('isDosenWali', true)->get();
        $jadwalKuliahs = JadwalKuliah::orderBy('nama_jadwal')->get();

        return view('admin.kelas.edit', compact('kela', 'jurusanContext', 'dosens', 'jadwalKuliahs'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusans,id',
            'dosen_nip' => 'required|exists:dosens,nip',
            'semester' => 'required|integer|min:1',
            'jadwal_kuliah_id' => 'required|exists:jadwal_kuliahs,id',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index', ['jurusan_id' => $kela->jurusan_id])
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->mahasiswas()->exists()) {
            return redirect()->route('admin.kelas.index', ['jurusan_id' => $kela->jurusan_id])
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki mahasiswa terdaftar.');
        }

        $jurusanId = $kela->jurusan_id;
        $kela->delete();

        return redirect()->route('admin.kelas.index', ['jurusan_id' => $jurusanId])
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
