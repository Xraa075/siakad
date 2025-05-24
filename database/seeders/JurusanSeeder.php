<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        // Asumsi ID Departemen dari DepartemenSeeder
        Jurusan::create(['nama_jurusan' => 'Teknik Informatika', 'departemen_id' => 2]); // ID = 1
        Jurusan::create(['nama_jurusan' => 'Sistem Informasi', 'departemen_id' => 2]); // ID = 2
        Jurusan::create(['nama_jurusan' => 'Teknik Elektro', 'departemen_id' => 1]); // ID = 3
        Jurusan::create(['nama_jurusan' => 'Manajemen', 'departemen_id' => 3]); // ID = 4
    }
}
