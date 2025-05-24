<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Untuk transaksi
use Illuminate\Validation\Rules; // Untuk aturan password
use Illuminate\Support\Str;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'kelas.jurusan']) // Eager load user dan kelas (beserta jurusan dari kelas)
            ->orderBy('nama')
            ->paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get(); // Untuk dropdown Kelas
        return view('admin.mahasiswa.create', compact('kelasList'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            // 1. Generate Login Email dari Nama Lengkap
            $namaLengkap = $request->nama;

            // Langkah 1: Hilangkan semua karakter KECUALI huruf, angka, dan spasi.
            // Spasi akan dihilangkan di langkah berikutnya.
            // Ini mempertahankan huruf besar dan kecil serta angka.
            $cleanedName = preg_replace("/[^A-Za-z0-9\s]/", '', $namaLengkap);

            // Langkah 2: Hilangkan semua spasi
            $baseEmailName = str_replace(' ', '', $cleanedName);

            // Langkah 3: Ubah semua menjadi huruf kecil
            $baseEmailName = Str::lower($baseEmailName);

            if (empty($baseEmailName)) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Nama tidak valid untuk menghasilkan email login (setelah dibersihkan menjadi kosong).');
            }

            $loginEmail = $baseEmailName . '@student.com';
            $counter = 1;
            // Cek keunikan email login, tambahkan angka jika sudah ada
            while (User::where('email', $loginEmail)->exists()) {
                $loginEmail = $baseEmailName . $counter . '@student.com';
                $counter++;
                if ($counter > 100) { // Batas pengaman
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Tidak dapat menghasilkan email login unik setelah beberapa percobaan. Silakan periksa data atau hubungi administrator.');
                }
            }

            // 2. Buat User record
            $user = User::create([
                'name' => $request->nama, // Nama lengkap asli tetap disimpan di 'name' user
                'email' => $loginEmail,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);

            // 3. Buat Mahasiswa record
            Mahasiswa::create([
                'nrp' => $request->nrp,
                'user_id' => $user->id,
                'nama' => $request->nama, // Nama lengkap asli
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

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        // Eager load relasi yang mungkin dibutuhkan di halaman show
        $mahasiswa->load(['user', 'kelas.jurusan', 'frs.matakuliah', 'nilai.matakuliah.dosenPJMK']);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $mahasiswa->load('user'); // Pastikan data user ter-load untuk form
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'kelasList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $user = $mahasiswa->user;

        $request->validate([
            'nrp' => 'required|string|max:20|unique:mahasiswas,nrp,' . $mahasiswa->nrp . ',nrp',
            'nama' => 'required|string|max:100',
            // Email login tidak diubah dari form ini
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|integer|min:1|max:14',
            'no_telp' => 'nullable|string|max:20',
            'email_kontak' => 'nullable|email|max:255|unique:mahasiswas,email_kontak,' . $mahasiswa->nrp . ',nrp', // Unik, abaikan record saat ini
        ]);

        DB::beginTransaction();
        try {
            // 1. Update User record (nama, dan password jika diisi)
            $userData = [
                'name' => $request->nama,
            ];
            // Email login tidak diupdate di sini
            // if ($request->filled('email_login_baru')) { /* logika jika ingin ada update email login terpisah */ }

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // 2. Update Mahasiswa record
            $mahasiswa->update([
                'nrp' => $request->nrp, // Sebenarnya NRP jarang diubah, tapi kita ikutkan
                'nama' => $request->nama,
                'kelas_id' => $request->kelas_id,
                'semester' => $request->semester,
                'no_telp' => $request->no_telp,
                'email_kontak' => $request->email_kontak, // Update email kontak
            ]);

            DB::commit();
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data Mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data mahasiswa. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        DB::beginTransaction();
        try {
            // Hapus data terkait mahasiswa dulu jika ada (misal FRS, Nilai)
            // $mahasiswa->frs()->delete();
            // $mahasiswa->nilai()->delete();
            // Atau atur ON DELETE CASCADE di database

            $user = $mahasiswa->user;
            $mahasiswa->delete(); // Hapus record mahasiswa

            if ($user) {
                $user->delete(); // Hapus record user terkait
            }

            DB::commit();
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error $e->getMessage()
            return redirect()->route('admin.mahasiswa.index')
                ->with('error', 'Gagal menghapus mahasiswa. Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
