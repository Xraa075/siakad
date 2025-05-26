<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::with([
            'kelas.jadwalKuliah.jadwalMatakuliahs.matakuliah',
            'kelas.jadwalKuliah.jadwalMatakuliahs.dosenPengajar1',
            'kelas.jadwalKuliah.jadwalMatakuliahs.dosenPengajar2'
        ])->where('user_id', $user->id)->firstOrFail();

        $jadwalMatakuliah = $mahasiswa->kelas->jadwalKuliah->jadwalMatakuliahs ?? collect();

        return view('mahasiswa.jadwal.index', compact('jadwalMatakuliah'));
    }
}
