<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = Matakuliah::with(['dosenPJMK', 'jurusan'])
            ->orderBy('nama_matakuliah')
            ->paginate(10);
        return view('admin.matakuliah.index', compact('matakuliahs'));
    }


    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.matakuliah.create', compact('dosens', 'jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:100',
            'dosen_nip' => 'required|exists:dosens,nip',
            'jurusan_id' => 'required|exists:jurusans,id',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        Matakuliah::create($request->all());

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function show(Matakuliah $matakuliah)
    {
        return view('admin.matakuliah.show', compact('matakuliah'));
    }

    public function edit(Matakuliah $matakuliah)
    {
        $dosens = Dosen::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.matakuliah.edit', compact('matakuliah', 'dosens', 'jurusans'));
    }

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

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
