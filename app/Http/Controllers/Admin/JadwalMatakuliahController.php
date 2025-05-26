<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalMatakuliah;
use App\Models\JadwalKuliah;
use App\Models\Matakuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class JadwalMatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $jadwalKuliahId = $request->query('jadwal_kuliah_id');

        if (!$jadwalKuliahId) {
            return redirect()->route('admin.jadwalkuliah.index')
                ->with('error', 'Harap pilih Jadwal Kuliah terlebih dahulu.');
        }
        $jadwalKuliahContext = JadwalKuliah::findOrFail($jadwalKuliahId);
        $jadwalMatakuliahs = JadwalMatakuliah::where('jadwal_kuliah_id', $jadwalKuliahId)
            ->with(['matakuliah', 'dosenPengajar1', 'dosenPengajar2'])
            ->orderBy('hari')->orderBy('jam_mulai')
            ->paginate(15);

        $pageTitle = "Detail Jadwal untuk: " . $jadwalKuliahContext->nama_jadwal;
        return view('admin.jadwalmatakuliah.index', compact('jadwalMatakuliahs', 'jadwalKuliahContext', 'pageTitle'));
    }

    public function create(Request $request)
    {
        $jadwalKuliahId = $request->query('jadwal_kuliah_id');
        if (!$jadwalKuliahId) {
            return redirect()->route('admin.jadwalkuliah.index')
                ->with('error', 'Harap pilih Jadwal Kuliah terlebih dahulu untuk menambah detail jadwal.');
        }
        $jadwalKuliahContext = JadwalKuliah::findOrFail($jadwalKuliahId);
        $matakuliahs = Matakuliah::orderBy('nama_matakuliah')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.jadwalmatakuliah.create', compact('jadwalKuliahContext', 'matakuliahs', 'dosens', 'hariOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_kuliah_id' => 'required|exists:jadwal_kuliahs,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'dosen_nip' => 'required|exists:dosens,nip',
            'dosen_pengajar2_nip' => 'nullable|exists:dosens,nip|different:dosen_nip',
            'hari' => 'required|string|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
            'semester' => 'required|integer|min:1',
        ]);
        JadwalMatakuliah::create($request->all());
        return redirect()->route('admin.jadwalmatakuliah.index', ['jadwal_kuliah_id' => $request->jadwal_kuliah_id])
            ->with('success', 'Detail jadwal mata kuliah berhasil ditambahkan.');
    }

    public function edit(JadwalMatakuliah $jadwalmatakuliah)
    {
        $jadwalmatakuliah->load(['jadwalKuliah', 'matakuliah', 'dosenPengajar1', 'dosenPengajar2']);
        $jadwalKuliahContext = $jadwalmatakuliah->jadwalKuliah;
        $matakuliahs = Matakuliah::orderBy('nama_matakuliah')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.jadwalmatakuliah.edit', compact('jadwalmatakuliah', 'jadwalKuliahContext', 'matakuliahs', 'dosens', 'hariOptions'));
    }

    public function update(Request $request, JadwalMatakuliah $jadwalmatakuliah)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'dosen_nip' => 'required|exists:dosens,nip',
            'dosen_pengajar2_nip' => 'nullable|exists:dosens,nip|different:dosen_nip',
            'hari' => 'required|string|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
            'semester' => 'required|integer|min:1',
        ]);
        $jadwalmatakuliah->update($request->all());
        return redirect()->route('admin.jadwalmatakuliah.index', ['jadwal_kuliah_id' => $jadwalmatakuliah->jadwal_kuliah_id])
            ->with('success', 'Detail jadwal mata kuliah berhasil diperbarui.');
    }

    public function destroy(JadwalMatakuliah $jadwalmatakuliah)
    {
        $jadwalKuliahId = $jadwalmatakuliah->jadwal_kuliah_id;
        $jadwalmatakuliah->delete();
        return redirect()->route('admin.jadwalmatakuliah.index', ['jadwal_kuliah_id' => $jadwalKuliahId])
            ->with('success', 'Detail jadwal mata kuliah berhasil dihapus.');
    }
}
