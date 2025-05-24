<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create(); // Contoh jika menggunakan factory

        $this->call([
            UserSeeder::class,       // Buat user dulu (admin, dosen, mahasiswa)
            DepartemenSeeder::class,
            JurusanSeeder::class,    // Butuh Departemen
            DosenSeeder::class,      // Butuh User (dosen) dan Jurusan
            JadwalKuliahSeeder::class, // Jika ada
            KelasSeeder::class,      // Butuh Jurusan, Dosen (wali), JadwalKuliah
            MahasiswaSeeder::class,  // Butuh User (mahasiswa) dan Kelas
            MatakuliahSeeder::class, // Butuh Dosen (PJMK) dan Jurusan
            // Tambahkan seeder lain di sini sesuai urutan dependensi
            // FrsMahasiswaSeeder::class,
            // JadwalMatakuliahSeeder::class,
            // NilaiMahasiswaSeeder::class,
        ]);
    }
}
