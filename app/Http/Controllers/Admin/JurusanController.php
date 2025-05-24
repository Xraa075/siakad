<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Departemen;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $departemenId = $request->query('departemen_id');
        $departemen = null;
        $jurusansQuery = Jurusan::query();

        if ($departemenId) {
            $departemen = Departemen::findOrFail($departemenId);
            $jurusansQuery->where('departemen_id', $departemenId);
        } else {
            // Jika tidak ada departemen_id, mungkin tampilkan semua jurusan
            // atau redirect ke pemilihan departemen. Untuk saat ini, kita fokus pada kasus ada departemen_id.
            // Atau, bisa juga throw error atau redirect.
            // Untuk alur yang diminta, halaman ini harus selalu punya konteks departemen.
            return redirect()->route('admin.departemen.index')->with('info', 'Silakan pilih departemen terlebih dahulu untuk melihat jurusan.');
        }

        $jurusans = $jurusansQuery->orderBy('nama_jurusan')->paginate(10);

        return view('admin.jurusan.index', compact('jurusans', 'departemen'));
    }

    public function create(Request $request)
    {
        // Ambil departemen_id dari query string untuk form create
        $departemenId = $request->query('departemen_id');
        $departemenDipilih = null;
        if ($departemenId) {
            $departemenDipilih = Departemen::find($departemenId);
        }
        $departemens = Departemen::orderBy('nama_departemen')->get(); // Untuk dropdown jika departemenId tidak ada
        return view('admin.jurusan.create', compact('departemens', 'departemenDipilih'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100',
            'departemen_id' => 'required|exists:departemens,id',
            // Pastikan unique constraint memperhitungkan departemen_id jika nama jurusan bisa sama di departemen berbeda
            // 'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan,NULL,id,departemen_id,'.$request->departemen_id,
        ], [
            'nama_jurusan.required' => 'Nama jurusan tidak boleh kosong.',
            'departemen_id.required' => 'Departemen harus dipilih.',
            'departemen_id.exists' => 'Departemen yang dipilih tidak valid.',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('admin.jurusan.index', ['departemen_id' => $request->departemen_id])
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        $departemens = Departemen::orderBy('nama_departemen')->get();
        $departemenDipilih = $jurusan->departemen; // Departemen saat ini dari jurusan yang diedit
        return view('admin.jurusan.edit', compact('jurusan', 'departemens', 'departemenDipilih'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100',
            'departemen_id' => 'required|exists:departemens,id',
            // 'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan,'.$jurusan->id.',id,departemen_id,'.$request->departemen_id,
        ]);

        $jurusan->update($request->all());

        return redirect()->route('admin.jurusan.index', ['departemen_id' => $jurusan->departemen_id])
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $departemenId = $jurusan->departemen_id; // Simpan untuk redirect
        // Tambahkan logika pengecekan relasi lain jika ada (misal ke tabel kelas, matakuliah, dll)
        $jurusan->delete();
        return redirect()->route('admin.jurusan.index', ['departemen_id' => $departemenId])
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
