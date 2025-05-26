<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalMatakuliah;
use App\Models\Dosen;

class JadwalDosenController extends Controller
{
    public function index()
    {
        $nip = Dosen::where('user_id', Auth::id())->value('nip');

        $jadwalList = JadwalMatakuliah::with(['matakuliah', 'jadwalKuliah'])
            ->where(function ($q) use ($nip) {
                $q->where('dosen_nip', $nip)
                    ->orWhere('dosen_pengajar2_nip', $nip);
            })
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('dosen.jadwal.index', compact('jadwalList'));
    }
}
