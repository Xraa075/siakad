<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrsMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;

class FrsMahasiswaController extends Controller
{
    public function index()
    {
        $frs = FrsMahasiswa::with(['mahasiswa', 'matakuliah'])->get();
        return view('admin.frs.index', compact('frs'));
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $matakuliahs = MataKuliah::all();
        return view('admin.frs.create', compact('mahasiswas', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_nrp' => 'required|exists:mahasiswas,nrp',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'semester' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
        ]);
        $validated['status'] = 'belum acc';
        $validated['available'] = $request->has('available');
        FrsMahasiswa::create($validated);
        return redirect()->route('admin.frs-mahasiswa.index')->with('success', 'FRS berhasil ditambahkan.');
    }


    public function edit(FrsMahasiswa $frs_mahasiswa)
    {
        $mahasiswas = Mahasiswa::all();
        $matakuliahs = MataKuliah::all();
        return view('admin.frs.edit', compact('frs_mahasiswa', 'mahasiswas', 'matakuliahs'));
    }

    public function update(Request $request, FrsMahasiswa $frs_mahasiswa)
    {
        $request->merge([
            'available' => $request->has('available') ? 1 : 0,
        ]);

        $request->validate([
            'mahasiswa_nrp' => 'required|exists:mahasiswas,nrp',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'semester' => 'required|integer|min:1',
            'status' => 'required|in:acc,belum acc',
            'tanggal_pengajuan' => 'required|date',
            'available' => 'nullable|boolean',
        ]);

        $frs_mahasiswa->update([
            'mahasiswa_nrp' => $request->mahasiswa_nrp,
            'matakuliah_id' => $request->matakuliah_id,
            'semester' => $request->semester,
            'status' => $request->status,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'available' => $request->has('available'),
        ]);

        return redirect()->route('admin.frs-mahasiswa.index')->with('success', 'FRS berhasil diperbarui.');
    }


    public function destroy(FrsMahasiswa $frs_mahasiswa)
    {
        $frs_mahasiswa->delete();
        return redirect()->route('admin.frs-mahasiswa.index')->with('success', 'FRS berhasil dihapus.');
    }
}
