<?php

namespace Database\Seeders;

// database/seeders/NilaiMahasiswaSeeder.php

use Illuminate\Database\Seeder;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Dosen;

class NilaiMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswaAndi = Mahasiswa::where('nrp', 'MHS001')->first();
        $mahasiswaCitra = Mahasiswa::where('nrp', 'MHS002')->first();

        $matakuliahDaspro = Matakuliah::where('nama_matakuliah', 'Dasar Pemrograman')->first();
        // $matakuliahAlgo = Matakuliah::where('nama_matakuliah', 'Algoritma dan Struktur Data')->first();
        $matakuliahAsi = Matakuliah::where('nama_matakuliah', 'Analisis Sistem Informasi')->first();

        $dosenBudi = Dosen::where('nip', 'DSN001')->first();
        $dosenSiti = Dosen::where('nip', 'DSN002')->first();

        if ($mahasiswaAndi && $matakuliahDaspro && $dosenBudi) {
            NilaiMahasiswa::firstOrCreate(
                [
                    'mahasiswa_nrp' => $mahasiswaAndi->nrp,
                    'matakuliah_id' => $matakuliahDaspro->id,
                    'dosen_nip' => $dosenBudi->nip, // Dosen yang menginput/PJMK
                    'semester' => $matakuliahDaspro->semester, // Semester matkul diambil
                ],
                [
                    'nilai_uts' => 80.50,
                    'nilai_uas' => 75.00,
                    'nilai_tugas' => 85.00,
                    'nilai_akhir' => 79.50, // Hitung sesuai bobot jika ada
                    'grade' => 'B+',
                ]
            );
        }

        if ($mahasiswaCitra && $matakuliahAsi && $dosenSiti) {
            NilaiMahasiswa::firstOrCreate(
                [
                    'mahasiswa_nrp' => $mahasiswaCitra->nrp,
                    'matakuliah_id' => $matakuliahAsi->id,
                    'dosen_nip' => $dosenSiti->nip,
                    'semester' => $matakuliahAsi->semester,
                ],
                [
                    'nilai_uts' => 90.00,
                    'nilai_uas' => 88.50,
                    'nilai_tugas' => 92.00,
                    'nilai_akhir' => 89.90,
                    'grade' => 'A',
                ]
            );
        }
        // Tambahkan data nilai lainnya sesuai kebutuhan
    }
}
