<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\User;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $userBudi = User::where('email', 'budisantoso@siakad.test')->first();
        $userSiti = User::where('email', 'sitiaminah@siakad.test')->first();

        if ($userBudi) {
            Dosen::create([
                'nip' => 'DSN001',
                'user_id' => $userBudi->id,
                'nama' => $userBudi->name, // Ambil dari user
                'email_kontak' => 'kontak.budi@example.com',
                'jurusan_id' => 1, // Asumsi ID Jurusan Teknik Informatika
                'no_telp' => '081234567890',
                'isDosenWali' => true,
            ]);
        }

        if ($userSiti) {
            Dosen::create([
                'nip' => 'DSN002',
                'user_id' => $userSiti->id,
                'nama' => $userSiti->name, // Ambil dari user
                'email_kontak' => 'kontak.siti@example.com',
                'jurusan_id' => 2, // Asumsi ID Jurusan Sistem Informasi
                'no_telp' => '081209876543',
                'isDosenWali' => false,
            ]);
        }
    }
}
