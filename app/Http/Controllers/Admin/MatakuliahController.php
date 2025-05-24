<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load relasi dosen dan jurusan untuk efisiensi
        $matakuliahs = Matakuliah::with(['dosenPJMK', 'jurusan'])
                                ->orderBy('nama_matakuliah')
                                ->paginate(10);
        return view('admin.matakuliah.index', compact('matakuliahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get(); // Untuk dropdown Dosen PJMK
        $jurusans = Jurusan::orderBy('nama_jurusan')->get(); // Untuk dropdown Jurusan
        return view('admin.matakuliah.create', compact('dosens', 'jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:100',
            'dosen_nip' => 'required|exists:dosens,nip', // PJMK
            'jurusan_id' => 'required|exists:jurusans,id',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8', // Asumsi semester 1-8
        ]);

        Matakuliah::create($request->all());

        return redirect()->route('admin.matakuliah.index')
                         ->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Matakuliah $matakuliah)
    {
        // Anda bisa membuat view show jika diperlukan, atau redirect ke edit/index
        return view('admin.matakuliah.show', compact('matakuliah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matakuliah $matakuliah)
    {
        $dosens = Dosen::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.matakuliah.edit', compact('matakuliah', 'dosens', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:100',
            'dosen_nip' => 'required|exists:dosens,nip',
            'jurusan_id' => 'required|exists:jurusans,id',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('admin.matakuliah.index')
                         ->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        // Tambahkan pengecekan relasi jika matakuliah sudah diambil di FRS, Jadwal, atau Nilai
        // if ($matakuliah->frsMahasiswas()->exists() || $matakuliah->detailJadwalMatakuliah()->exists() || $matakuliah->nilaiMahasiswas()->exists()) {
        //     return back()->with('error', 'Mata Kuliah tidak dapat dihapus karena sudah digunakan dalam data lain (FRS, Jadwal, Nilai).');
        // }
        $matakuliah->delete();

        return redirect()->route('admin.matakuliah.index')
                         ->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
