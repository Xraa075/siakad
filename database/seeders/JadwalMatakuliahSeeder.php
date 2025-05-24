<?php

namespace Database\Seeders;

// database/seeders/JadwalMatakuliahSeeder.php

use Illuminate\Database\Seeder;
use App\Models\JadwalMatakuliah;
use App\Models\JadwalKuliah;
use App\Models\Matakuliah;
use App\Models\Dosen;

class JadwalMatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $jadwalGenap2025 = JadwalKuliah::find(1); // Asumsi ID 1 untuk Semester Genap 2024/2025

        $matakuliahDaspro = Matakuliah::where('nama_matakuliah', 'Dasar Pemrograman')->first();
        $matakuliahAlgo = Matakuliah::where('nama_matakuliah', 'Algoritma dan Struktur Data')->first();
        $matakuliahAsi = Matakuliah::where('nama_matakuliah', 'Analisis Sistem Informasi')->first();

        $dosenBudi = Dosen::where('nip', 'DSN001')->first();
        $dosenSiti = Dosen::where('nip', 'DSN002')->first();

        if ($jadwalGenap2025 && $matakuliahDaspro && $dosenBudi) {
            JadwalMatakuliah::firstOrCreate(
                [
                    'jadwal_kuliah_id' => $jadwalGenap2025->id,
                    'matakuliah_id' => $matakuliahDaspro->id,
                    'dosen_nip' => $dosenBudi->nip,
                    'hari' => 'Senin',
                    'jam_mulai' => '08:00:00',
                ],
                [
                    // 'dosen_pengajar2_nip' => null, // Opsional
                    'jam_selesai' => '09:40:00',
                    'ruangan' => 'Lab Komp 1',
                    'semester' => $matakuliahDaspro->semester, // Ambil dari matakuliah
                ]
            );
        }

        if ($jadwalGenap2025 && $matakuliahAlgo && $dosenBudi) {
            JadwalMatakuliah::firstOrCreate(
                [
                    'jadwal_kuliah_id' => $jadwalGenap2025->id,
                    'matakuliah_id' => $matakuliahAlgo->id,
                    'dosen_nip' => $dosenBudi->nip,
                    'hari' => 'Rabu',
                    'jam_mulai' => '10:00:00',
                ],
                [
                    'dosen_pengajar2_nip' => $dosenSiti ? $dosenSiti->nip : null, // Contoh dosen kedua
                    'jam_selesai' => '12:30:00',
                    'ruangan' => 'Teori 2A',
                    'semester' => $matakuliahAlgo->semester,
                ]
            );
        }

        if ($jadwalGenap2025 && $matakuliahAsi && $dosenSiti) {
            JadwalMatakuliah::firstOrCreate(
                [
                    'jadwal_kuliah_id' => $jadwalGenap2025->id,
                    'matakuliah_id' => $matakuliahAsi->id,
                    'dosen_nip' => $dosenSiti->nip,
                    'hari' => 'Selasa',
                    'jam_mulai' => '13:00:00',
                ],
                [
                    'jam_selesai' => '14:40:00',
                    'ruangan' => 'Audit 1',
                    'semester' => $matakuliahAsi->semester,
                ]
            );
        }
    }
}
