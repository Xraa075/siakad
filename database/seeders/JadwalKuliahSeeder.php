<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKuliah;

class JadwalKuliahSeeder extends Seeder
{
    public function run(): void
    {
        JadwalKuliah::firstOrCreate(
            ['id' => 1], // You can specify the ID if you want to ensure it's '1'
            ['nama_jadwal' => 'Semester Genap 2024/2025']
        );
        JadwalKuliah::firstOrCreate(
            ['id' => 2],
            ['nama_jadwal' => 'Semester Ganjil 2025/2026']
        );
        // Add more if needed
    }
}
