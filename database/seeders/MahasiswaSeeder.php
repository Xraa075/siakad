<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $userAndi = User::where('email', 'andipratama@siakad.test')->first();
        $userCitra = User::where('email', 'citralestari@siakad.test')->first();

        if ($userAndi) {
            Mahasiswa::create([
                'nrp' => 'MHS001',
                'user_id' => $userAndi->id,
                'nama' => $userAndi->name,
                'email_kontak' => 'kontak.andi@example.com',
                'kelas_id' => 1, // Asumsi ID Kelas TI-2A
                'semester' => 2,
                'no_telp' => '085678901234',
            ]);
        }

        if ($userCitra) {
            Mahasiswa::create([
                'nrp' => 'MHS002',
                'user_id' => $userCitra->id,
                'nama' => $userCitra->name,
                'email_kontak' => 'kontak.citra@example.com',
                'kelas_id' => 2, // Asumsi ID Kelas SI-4B
                'semester' => 4,
                'no_telp' => '085012345678',
            ]);
        }
    }
}
