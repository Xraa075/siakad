<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matakuliah;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        Matakuliah::create([
            'nama_matakuliah' => 'Dasar Pemrograman',
            'dosen_nip' => 'DSN001', // PJMK: Budi Santoso
            'jurusan_id' => 1,       // Jurusan: Teknik Informatika
            'semester' => 1,
            'sks' => 3,
        ]);

        Matakuliah::create([
            'nama_matakuliah' => 'Analisis Sistem Informasi',
            'dosen_nip' => 'DSN002', // PJMK: Siti Aminah
            'jurusan_id' => 2,       // Jurusan: Sistem Informasi
            'semester' => 3,
            'sks' => 3,
        ]);

         Matakuliah::create([
            'nama_matakuliah' => 'Algoritma dan Struktur Data',
            'dosen_nip' => 'DSN001', // PJMK: Budi Santoso
            'jurusan_id' => 1,       // Jurusan: Teknik Informatika
            'semester' => 2,
            'sks' => 4,
        ]);
    }
}
