<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departemen;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        Departemen::create(['nama_departemen' => 'Fakultas Teknik']); // ID = 1
        Departemen::create(['nama_departemen' => 'Fakultas Ilmu Komputer']); // ID = 2
        Departemen::create(['nama_departemen' => 'Fakultas Ekonomi dan Bisnis']); // ID = 3
    }
}
