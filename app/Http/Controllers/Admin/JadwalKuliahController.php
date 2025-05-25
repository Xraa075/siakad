<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        $jadwalkuliahs = JadwalKuliah::orderBy('nama_jadwal')->paginate(10);
        return view('admin.jadwalkuliah.index', compact('jadwalkuliahs'));
    }

    public function create()
    {
        return view('admin.jadwalkuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jadwal' => 'required|string|max:255|unique:jadwal_kuliahs,nama_jadwal',
        ]);

        JadwalKuliah::create($request->all());
        return redirect()->route('admin.jadwalkuliah.index')->with('success', 'Jadwal kuliah berhasil dibuat.');
    }
    public function show(JadwalKuliah $jadwalkuliah)
    {
        return view('admin.jadwalkuliah.show', compact('jadwalkuliah'));
    }


    public function edit(JadwalKuliah $jadwalkuliah)
    {
        return view('admin.jadwalkuliah.edit', compact('jadwalkuliah'));
    }

    public function update(Request $request, JadwalKuliah $jadwalkuliah)
    {
        $request->validate([
            'nama_jadwal' => 'required|string|max:255|unique:jadwal_kuliahs,nama_jadwal,' . $jadwalkuliah->id,
        ]);

        $jadwalkuliah->update($request->all());

        return redirect()->route('admin.jadwalkuliah.index')->with('success', 'Jadwal kuliah berhasil diperbarui.');
    }

    public function destroy(JadwalKuliah $jadwalkuliah)
    {
        if ($jadwalkuliah->jadwalMatakuliahs()->exists()) {
            return redirect()->route('admin.jadwalkuliah.index')->with('error', 'Jadwal Kuliah tidak dapat dihapus karena memiliki detail jadwal mata kuliah terkait.');
        }
        if ($jadwalkuliah->kelas()->exists()) {
            return redirect()->route('admin.jadwalkuliah.index')->with('error', 'Jadwal Kuliah tidak dapat dihapus karena digunakan oleh tabel Kelas.');
        }
        $jadwalkuliah->delete();
        return redirect()->route('admin.jadwalkuliah.index')->with('success', 'Jadwal kuliah berhasil dihapus.');
    }
}
