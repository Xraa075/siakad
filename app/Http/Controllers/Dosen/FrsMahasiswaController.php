<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FrsMahasiswa;

class FrsMahasiswaController extends Controller
{
    public function index()
    {
        $nip = \App\Models\Dosen::where('user_id', Auth::id())->value('nip');

        $frsList = \App\Models\FrsMahasiswa::with(['mahasiswa.kelas.dosenWali', 'matakuliah'])
            ->where('status_ambil', 'ambil')
            ->where('status', 'belum acc')
            ->whereHas('mahasiswa.kelas', function ($query) use ($nip) {
                $query->where('dosen_nip', $nip);
            })
            ->get();

        return view('dosen.frs.index', compact('frsList'));
    }


    public function acc($id)
    {
        $nip = \App\Models\Dosen::where('user_id', Auth::id())->value('nip');

        $frs = FrsMahasiswa::with('mahasiswa.kelas.dosenWali')
            ->where('id', $id)
            ->where('status_ambil', 'ambil')
            ->where('status', 'belum acc')
            ->whereHas('mahasiswa.kelas', function ($query) use ($nip) {
                $query->where('dosen_nip', $nip);
            })
            ->firstOrFail();

        $frs->update([
            'status' => 'acc'
        ]);

        return redirect()->back()->with('success', 'FRS berhasil disetujui.');
    }
}
