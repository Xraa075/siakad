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
        return view('admin.departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemens,nama_departemen',
        ]);

        Departemen::create($request->only('nama_departemen'));

        return redirect()->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id)
    {

        $departemen = Departemen::findOrFail($id);
        return view('admin.departemen.edit', compact('departemen'));
    }

    public function update(Request $request, $id)
    {
        $departemen = Departemen::findOrFail($id);

        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemens,nama_departemen,' . $departemen->id,
        ]);

        $isUpdated = $departemen->update([
            'nama_departemen' => $request->nama_departemen,
        ]);

        if ($isUpdated) {
            return redirect()->route('admin.departemen.index')
                ->with('success', 'Departemen berhasil diperbarui.');
        } else {
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
}
