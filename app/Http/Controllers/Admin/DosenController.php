<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::with(['user', 'jurusan'])
            ->orderBy('nama')
            ->paginate(10);
        return view('admin.dosen.index', compact('dosens'));
    }

    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.dosen.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:dosens,nip',
            'nama' => 'required|string|max:100',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jurusan_id' => 'required|exists:jurusans,id',
            'email_kontak' => 'nullable|email|max:255|unique:dosens,email_kontak',
            'no_telp' => 'nullable|string|max:20',
            'isDosenWali' => 'sometimes|boolean',
        ]);

        DB::beginTransaction();
        try {
            $namaLengkap = $request->nama;
            $cleanedName = preg_replace("/[^A-Za-z0-9\s]/", '', $namaLengkap);
            $baseEmailName = str_replace(' ', '', $cleanedName);
            $baseEmailName = Str::lower($baseEmailName);
            $loginEmail = $baseEmailName . '@dosen.siakad.test';
            $counter = 1;

            $originalLoginEmail = $loginEmail;
            while (User::where('email', $loginEmail)->exists()) {
                $loginEmail = Str::lower($request->nip) . $counter . '@dosen.siakad.test';
                $counter++;
                if ($counter > 100) {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Tidak dapat menghasilkan email login unik untuk dosen.');
                }
            }

            $user = User::create([
                'name' => $request->nama,
                'email' => $loginEmail,
                'password' => Hash::make($request->password),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ]);

            Dosen::create([
                'nip' => $request->nip,
                'user_id' => $user->id,
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'email_kontak' => $request->email_kontak,
                'no_telp' => $request->no_telp,
                'isDosenWali' => $request->boolean('isDosenWali'),
            ]);

            DB::commit();
            return redirect()->route('admin.dosen.index')
                ->with('success', "Dosen berhasil ditambahkan. Email login: {$loginEmail}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat store dosen: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Gagal menambahkan dosen. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Dosen $dosen)
    {
        $dosen->load(['user', 'jurusan', 'kelasWali', 'matakuliahPJMK']);
        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $dosen->load('user');
        return view('admin.dosen.edit', compact('dosen', 'jurusans'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $user = $dosen->user;

        $request->validate([
            'nip' => 'required|string|max:20|unique:dosens,nip,' . $dosen->nip . ',nip',
            'nama' => 'required|string|max:100',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password opsional
            'jurusan_id' => 'required|exists:jurusans,id',
            'email_kontak' => 'nullable|email|max:255|unique:dosens,email_kontak,' . $dosen->nip . ',nip',
            'no_telp' => 'nullable|string|max:20',
            'isDosenWali' => 'sometimes|boolean',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->nama,
                // Email login tidak diubah di sini, atau perlu logika khusus jika boleh diubah
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            $dosen->update([
                'nip' => $request->nip, // Biasanya NIP tidak diubah, tapi bisa jika diperlukan
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'email_kontak' => $request->email_kontak,
                'no_telp' => $request->no_telp,
                'isDosenWali' => $request->boolean('isDosenWali'),
            ]);

            DB::commit();
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data Dosen berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat update dosen: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Gagal memperbarui data dosen. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Dosen $dosen)
    {
        // Pengecekan relasi sebelum menghapus
        if ($dosen->kelasWali()->exists()) {
            return redirect()->route('admin.dosen.index')->with('error', 'Dosen tidak dapat dihapus karena masih menjadi dosen wali untuk beberapa kelas.');
        }
        if ($dosen->matakuliahPJMK()->exists()) {
            return redirect()->route('admin.dosen.index')->with('error', 'Dosen tidak dapat dihapus karena masih menjadi PJMK untuk beberapa mata kuliah.');
        }
        // Tambahkan pengecekan lain jika dosen terkait dengan jadwal mengajar atau nilai

        DB::beginTransaction();
        try {
            $user = $dosen->user;
            $dosen->delete(); // Hapus record dosen

            if ($user) {
                $user->delete(); // Hapus record user terkait
            }

            DB::commit();
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Dosen berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat destroy dosen: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return redirect()->route('admin.dosen.index')
                ->with('error', 'Gagal menghapus dosen. Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
