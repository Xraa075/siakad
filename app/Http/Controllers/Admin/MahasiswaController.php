<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'kelas.jurusan'])
            ->orderBy('nama')
            ->paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        return view('admin.mahasiswa.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|string|max:20|unique:mahasiswas,nrp',
            'nama' => 'required|string|max:100',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|integer|min:1|max:14',
            'no_telp' => 'nullable|string|max:20',
            'email_kontak' => 'nullable|email|max:255|unique:mahasiswas,email_kontak',
        ]);

        DB::beginTransaction();
        try {
            $namaLengkap = $request->nama;
            $cleanedName = preg_replace("/[^A-Za-z0-9\s]/", '', $namaLengkap);
            $baseEmailName = str_replace(' ', '', $cleanedName);
            $baseEmailName = Str::lower($baseEmailName);

            if (empty($baseEmailName)) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Nama tidak valid untuk menghasilkan email login (setelah dibersihkan menjadi kosong).');
            }
            $loginEmail = $baseEmailName . '@student.com';
            $counter = 1;
            while (User::where('email', $loginEmail)->exists()) {
                $loginEmail = $baseEmailName . $counter . '@student.com';
                $counter++;
                if ($counter > 100) {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Tidak dapat menghasilkan email login unik setelah beberapa percobaan. Silakan periksa data atau hubungi administrator.');
                }
            }
            $user = User::create([
                'name' => $request->nama,
                'email' => $loginEmail,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);

            Mahasiswa::create([
                'nrp' => $request->nrp,
                'user_id' => $user->id,
                'nama' => $request->nama,
                'kelas_id' => $request->kelas_id,
                'semester' => $request->semester,
                'no_telp' => $request->no_telp,
                'email_kontak' => $request->email_kontak,
            ]);

            DB::commit();
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', "Mahasiswa berhasil ditambahkan. Email login otomatis dibuat: {$loginEmail}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan mahasiswa. Terjadi kesalahan sistem.');
        }
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['user', 'kelas.jurusan', 'frs.matakuliah', 'nilai.matakuliah.dosenPJMK']);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $mahasiswa->load('user');
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'kelasList'));
    }


    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $user = $mahasiswa->user;

        $request->validate([
            'nrp' => 'required|string|max:20|unique:mahasiswas,nrp,' . $mahasiswa->nrp . ',nrp',
            'nama' => 'required|string|max:100',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|integer|min:1|max:14',
            'no_telp' => 'nullable|string|max:20',
            'email_kontak' => 'nullable|email|max:255|unique:mahasiswas,email_kontak,' . $mahasiswa->nrp . ',nrp', // Unik, abaikan record saat ini
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->nama,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);


            $mahasiswa->update([
                'nrp' => $request->nrp,
                'nama' => $request->nama,
                'kelas_id' => $request->kelas_id,
                'semester' => $request->semester,
                'no_telp' => $request->no_telp,
                'email_kontak' => $request->email_kontak,
            ]);

            DB::commit();
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data Mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data mahasiswa. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        DB::beginTransaction();
        try {
            $user = $mahasiswa->user;
            $mahasiswa->delete();

            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.mahasiswa.index')
                ->with('error', 'Gagal menghapus mahasiswa. Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
