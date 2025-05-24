<?php

namespace Database\Seeders;

// database/seeders/FrsMahasiswaSeeder.php

use Illuminate\Database\Seeder;
use App\Models\FrsMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class FrsMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data mahasiswa dan matakuliah yang sudah ada
        $mahasiswaAndi = Mahasiswa::where('nrp', 'MHS001')->first();
        $mahasiswaCitra = Mahasiswa::where('nrp', 'MHS002')->first();

        $matakuliahDaspro = Matakuliah::where('nama_matakuliah', 'Dasar Pemrograman')->first();
        $matakuliahAlgo = Matakuliah::where('nama_matakuliah', 'Algoritma dan Struktur Data')->first();
        $matakuliahAsi = Matakuliah::where('nama_matakuliah', 'Analisis Sistem Informasi')->first();

        if ($mahasiswaAndi && $matakuliahDaspro) {
            FrsMahasiswa::firstOrCreate(
                [
                    'mahasiswa_nrp' => $mahasiswaAndi->nrp,
                    'matakuliah_id' => $matakuliahDaspro->id,
                    'semester' => $mahasiswaAndi->semester, // Sesuaikan semester FRS
                ],
                [
                    'status' => 'acc',
                    'tanggal_pengajuan' => now()->subDays(10),
                ]
            );
        }

        if ($mahasiswaAndi && $matakuliahAlgo) {
            FrsMahasiswa::firstOrCreate(
                [
                    'mahasiswa_nrp' => $mahasiswaAndi->nrp,
                    'matakuliah_id' => $matakuliahAlgo->id,
                    'semester' => $mahasiswaAndi->semester,
                ],
                [
                    'status' => 'belum acc',
                    'tanggal_pengajuan' => now()->subDays(2),
                ]
            );
        }

        if ($mahasiswaCitra && $matakuliahAsi) {
            FrsMahasiswa::firstOrCreate(
                [
                    'mahasiswa_nrp' => $mahasiswaCitra->nrp,
                    'matakuliah_id' => $matakuliahAsi->id,
                    'semester' => $mahasiswaCitra->semester,
                ],
                [
                    'status' => 'acc',
                    'tanggal_pengajuan' => now()->subDays(5),
                ]
            );
        }
    }
}
