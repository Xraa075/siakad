<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\JadwalMatakuliah;
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

    public function create(Request $request)
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $selectedMahasiswa = null;
        $matakuliahOptions = collect();
        if ($request->filled('mahasiswa_nrp_selected')) {
            $selectedMahasiswa = Mahasiswa::with([
                'kelas.jadwalKuliah.jadwalMatakuliahs.matakuliah.dosenPJMK',
                'kelas.jurusan'
            ])->find($request->mahasiswa_nrp_selected);

            if ($selectedMahasiswa && $selectedMahasiswa->kelas && $selectedMahasiswa->kelas->jadwalKuliah) {
                $jadwalKuliahId = $selectedMahasiswa->kelas->jadwal_kuliah_id;
                $matakuliahDiJadwal = JadwalMatakuliah::where('jadwal_kuliah_id', $jadwalKuliahId)
                    ->where('semester', '<=', $selectedMahasiswa->semester)
                    ->with('matakuliah.dosenPJMK')
                    ->get()
                    ->pluck('matakuliah')
                    ->filter()
                    ->unique('id');

                foreach ($matakuliahDiJadwal as $mk) {
                    $sudahAdaNilai = NilaiMahasiswa::where('mahasiswa_nrp', $selectedMahasiswa->nrp)
                        ->where('matakuliah_id', $mk->id)
                        ->where('semester', $selectedMahasiswa->semester)
                        ->exists();
                    if (!$sudahAdaNilai) {
                        $matakuliahOptions->push($mk);
                    }
                }
                $matakuliahOptions = $matakuliahOptions->sortBy('nama_matakuliah');
            }
        }

        return view('admin.nilaimahasiswa.create', compact('mahasiswas', 'selectedMahasiswa', 'matakuliahOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_nrp' => 'required|exists:mahasiswas,nrp',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
        ], [
            'mahasiswa_nrp.required' => 'Mahasiswa harus dipilih.',
            'matakuliah_id.required' => 'Mata kuliah harus dipilih.',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_nrp);
        $matakuliah = Matakuliah::with('dosenPJMK')->findOrFail($request->matakuliah_id);

        if (!$matakuliah->dosenPJMK) {
            return back()->withInput()->with('error', 'Mata kuliah (' . $matakuliah->nama_matakuliah . ') tidak memiliki Dosen Penanggung Jawab (PJMK). Harap perbarui data mata kuliah.');
        }

        $semesterUntukNilai = $mahasiswa->semester;
        $dosenUntukNilaiNip = $matakuliah->dosen_nip;

        $existingNilai = NilaiMahasiswa::where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('matakuliah_id', $matakuliah->id)
            ->where('semester', $semesterUntukNilai)
            ->first();

        if ($existingNilai) {
            return back()->withInput()->with('error', 'Nilai untuk mahasiswa, mata kuliah, dan semester ini sudah ada. Silakan edit data yang ada.');
        }

        $nilai_akhir = $this->hitungNilaiAkhir(
            $request->nilai_uts,
            $request->nilai_uas,
            $request->nilai_tugas
        );
        $grade = $this->hitungGrade($nilai_akhir);

        NilaiMahasiswa::create([
            'mahasiswa_nrp' => $mahasiswa->nrp,
            'matakuliah_id' => $matakuliah->id,
            'dosen_nip' => $dosenUntukNilaiNip,
            'semester' => $semesterUntukNilai,
            'nilai_uts' => $request->nilai_uts,
            'nilai_uas' => $request->nilai_uas,
            'nilai_tugas' => $request->nilai_tugas,
            'nilai_akhir' => $nilai_akhir,
            'grade' => $grade,
        ]);

        return redirect()->route('admin.nilaimahasiswa.index')->with('success', 'Nilai mahasiswa berhasil ditambahkan.');
    }

    public function edit(NilaiMahasiswa $nilaimahasiswa)
    {
        $nilaimahasiswa->load(['mahasiswa', 'matakuliah.dosenPJMK', 'dosen']);
        $selectedMahasiswa = $nilaimahasiswa->mahasiswa;
        $matakuliahOptions = collect([$nilaimahasiswa->matakuliah]);

        return view('admin.nilaimahasiswa.edit', compact('nilaimahasiswa', 'selectedMahasiswa', 'matakuliahOptions'));
    }

    public function update(Request $request, NilaiMahasiswa $nilaimahasiswa)
    {
        $request->validate([
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

        $nilaimahasiswa->update([
            'nilai_uts' => $request->nilai_uts,
            'nilai_uas' => $request->nilai_uas,
            'nilai_tugas' => $request->nilai_tugas,
            'nilai_akhir' => $nilai_akhir,
            'grade' => $grade,
        ]);

        return redirect()->route('admin.nilaimahasiswa.index')->with('success', 'Nilai mahasiswa berhasil diperbarui.');
    }

    public function destroy(NilaiMahasiswa $nilaimahasiswa)
    {
        $nilaimahasiswa->delete();
        return redirect()->route('admin.nilaimahasiswa.index')->with('success', 'Nilai mahasiswa berhasil dihapus.');
    }
}
