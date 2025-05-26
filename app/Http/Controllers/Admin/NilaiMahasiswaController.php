<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class NilaiMahasiswaController extends Controller
{
    private function hitungGrade($nilai_akhir)
    {
        if ($nilai_akhir === null) return null;
        return match (true) {
            $nilai_akhir >= 85 => 'A',
            $nilai_akhir >= 75 => 'B',
            $nilai_akhir >= 65 => 'C',
            $nilai_akhir >= 50 => 'D',
            default => 'E',
        };
    }

    private function hitungNilaiAkhir($uts, $uas, $tugas)
    {
        if ($uts === null || $uas === null || $tugas === null) return null;
        return ($uts + $uas + $tugas) / 3;
    }

    public function index(Request $request)
    {
        $query = NilaiMahasiswa::with(['mahasiswa', 'matakuliah', 'dosen']);
        if ($request->filled('mahasiswa_nrp')) {
            $query->where('mahasiswa_nrp', $request->mahasiswa_nrp);
        }
        if ($request->filled('matakuliah_id')) {
            $query->where('matakuliah_id', $request->matakuliah_id);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $nilais = $query->orderBy('semester', 'desc')
            ->orderBy('mahasiswa_nrp')
            ->paginate(15);

        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $matakuliahs = Matakuliah::orderBy('nama_matakuliah')->get();
        return view('admin.nilaimahasiswa.index', compact('nilais', 'mahasiswas', 'matakuliahs'));
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $matakuliahs = Matakuliah::orderBy('nama_matakuliah')->get();
        $dosens = Dosen::orderBy('nama')->get();
        return view('admin.nilaimahasiswa.create', compact('mahasiswas', 'matakuliahs', 'dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_nrp' => 'required|exists:mahasiswas,nrp',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'dosen_nip' => 'required|exists:dosens,nip',
            'semester' => 'required|integer|min:1',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
        ], [
            'mahasiswa_nrp.required' => 'Mahasiswa harus dipilih.',
            'matakuliah_id.required' => 'Mata kuliah harus dipilih.',
        ]);

        $nilai_akhir = $this->hitungNilaiAkhir(
            $request->nilai_uts,
            $request->nilai_uas,
            $request->nilai_tugas
        );
        $grade = $this->hitungGrade($nilai_akhir);

        NilaiMahasiswa::create(array_merge(
            $request->only(['mahasiswa_nrp', 'matakuliah_id', 'dosen_nip', 'semester', 'nilai_uts', 'nilai_uas', 'nilai_tugas']),
            ['nilai_akhir' => $nilai_akhir, 'grade' => $grade]
        ));
        return redirect()->route('admin.nilaimahasiswa.index')->with('success', 'Nilai mahasiswa berhasil ditambahkan.');
    }

    public function edit(NilaiMahasiswa $nilaimahasiswa)
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $matakuliahs = Matakuliah::orderBy('nama_matakuliah')->get();
        $dosens = Dosen::orderBy('nama')->get();
        return view('admin.nilaimahasiswa.edit', compact('nilaimahasiswa', 'mahasiswas', 'matakuliahs', 'dosens'));
    }

    public function update(Request $request, NilaiMahasiswa $nilaimahasiswa)
    {
        $request->validate([
            'mahasiswa_nrp' => 'required|exists:mahasiswas,nrp',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'dosen_nip' => 'required|exists:dosens,nip',
            'semester' => 'required|integer|min:1',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
        ]);

        $nilai_akhir = $this->hitungNilaiAkhir(
            $request->nilai_uts,
            $request->nilai_uas,
            $request->nilai_tugas
        );
        $grade = $this->hitungGrade($nilai_akhir);

        $nilaimahasiswa->update(array_merge(
            $request->only(['mahasiswa_nrp', 'matakuliah_id', 'dosen_nip', 'semester', 'nilai_uts', 'nilai_uas', 'nilai_tugas']),
            ['nilai_akhir' => $nilai_akhir, 'grade' => $grade]
        ));

        return redirect()->route('admin.nilaimahasiswa.index')->with('success', 'Nilai mahasiswa berhasil diperbarui.');
    }

    public function destroy(NilaiMahasiswa $nilaimahasiswa)
    {
        $nilaimahasiswa->delete();
        return redirect()->route('admin.nilaimahasiswa.index')->with('success', 'Nilai mahasiswa berhasil dihapus.');
    }
}
