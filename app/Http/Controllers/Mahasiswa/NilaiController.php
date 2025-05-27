<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;

class NilaiController extends Controller
{
    /**
     * Display a listing of the student's grades.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'mahasiswa' || !$user->mahasiswa) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses untuk melihat halaman nilai mahasiswa.');
        }

        $mahasiswa = $user->mahasiswa;

        $query = NilaiMahasiswa::where('mahasiswa_nrp', $mahasiswa->nrp)
            ->with(['matakuliah', 'dosen'])
            ->orderBy('semester', 'asc')
            ->orderBy('matakuliah_id', 'asc');

        if ($request->filled('filter_semester')) {
            $query->where('semester', $request->filter_semester);
        }

        $nilais = $query->get();

        $semesterOptions = NilaiMahasiswa::where('mahasiswa_nrp', $mahasiswa->nrp)
            ->select('semester')
            ->distinct()
            ->orderBy('semester', 'asc')
            ->pluck('semester');

        return view('mahasiswa.nilai.index', compact('nilais', 'mahasiswa', 'semesterOptions'));
    }
}
