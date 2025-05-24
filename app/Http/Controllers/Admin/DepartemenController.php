<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::orderBy('nama_departemen')->paginate(10);
        return view('admin.departemen.index', compact('departemens'));
    }

    public function create()
    {
        // View ini mungkin akan sederhana, hanya menampilkan form partial atau
        // bisa juga digabungkan logikanya di index jika menggunakan modal.
        // Untuk saat ini, kita buat halaman create terpisah yang simpel.
        return view('admin.departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemens,nama_departemen',
        ]);

        Departemen::create($request->only('nama_departemen')); // Hanya ambil nama_departemen

        return redirect()->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id)
    {

        $departemen = Departemen::findOrFail($id);
        return view('admin.departemen.edit', compact('departemen'));
    }

    // app/Http/Controllers/Admin/DepartemenController.php
    public function update(Request $request, $id) // Menerima ID, bukan model binding langsung
    {
        $departemen = Departemen::findOrFail($id); // Cari departemen berdasarkan ID

        $request->validate([
            // Validasi: pastikan nama_departemen unik KECUALI untuk record saat ini
            'nama_departemen' => 'required|string|max:100|unique:departemens,nama_departemen,' . $departemen->id,
        ]);

        // Hanya update field yang relevan
        $isUpdated = $departemen->update([
            'nama_departemen' => $request->nama_departemen,
        ]);

        if ($isUpdated) {
            return redirect()->route('admin.departemen.index')
                ->with('success', 'Departemen berhasil diperbarui.');
        } else {
            // Ini jarang terjadi jika tidak ada error, tapi baik untuk jaga-jaga
            return back()->with('error', 'Gagal memperbarui departemen. Tidak ada data yang berubah atau terjadi kesalahan.');
        }
    }

    public function destroy($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->jurusans()->delete();
        $departemen->delete();
        return redirect()->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }

    // Method show() bisa Anda implementasikan jika perlu halaman detail departemen,
    // tapi berdasarkan permintaan, kita akan langsung ke list jurusan.
}
