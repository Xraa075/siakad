<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
// use App\Models\JadwalKuliah; // Jika ingin membuat JadwalKuliah dulu

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Buat JadwalKuliah default jika belum ada atau ambil ID yang sudah ada
        // $jadwalUmum = JadwalKuliah::firstOrCreate(['nama_jadwal' => 'Semester Genap 2024/2025']);

        Kelas::create([
            'nama_kelas' => 'TI-2A',
            'jurusan_id' => 1, // Asumsi ID Jurusan Teknik Informatika
            'dosen_nip' => 'DSN001', // Asumsi NIP Dosen Budi Santoso sebagai Wali
            'semester' => 2,
            'jadwal_kuliah_id' => 1, // Asumsi ID JadwalKuliah
        ]);

        Kelas::create([
            'nama_kelas' => 'SI-4B',
            'jurusan_id' => 2, // Asumsi ID Jurusan Sistem Informasi
            'dosen_nip' => 'DSN002', // Asumsi NIP Dosen Siti Aminah sebagai Wali
            'semester' => 4,
            'jadwal_kuliah_id' => 1, // Asumsi ID JadwalKuliah
        ]);
    }
}
