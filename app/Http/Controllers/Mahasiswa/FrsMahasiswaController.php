<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FrsMahasiswa;
use App\Models\Mahasiswa;

class FrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();

        $frsTersedia = FrsMahasiswa::with('matakuliah')
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('available', true)
            ->where('status_ambil', 'belum ambil')
            ->get();

        $frsTerambil = FrsMahasiswa::with('matakuliah')
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('status_ambil', 'ambil')
            ->get();

        return view('mahasiswa.frs.index', compact('frsTersedia', 'frsTerambil'));
    }

    public function ambil(Request $request, $id)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();

        $frs = FrsMahasiswa::where('id', $id)
            ->where('mahasiswa_nrp', $mahasiswa->nrp)
            ->where('available', true)
            ->where('status_ambil', 'belum ambil')
            ->firstOrFail();

        $frs->update([
            'status_ambil' => 'ambil',
            'tanggal_pengajuan' => now(),
            'status' => 'belum acc',
        ]);

        return redirect()->back()->with('success', 'FRS berhasil diambil.');
    }
}
