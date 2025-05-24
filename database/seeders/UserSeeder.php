<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin; // Tambahkan ini jika ingin membuat profil admin langsung
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User Admin
        $adminUser = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@siakad.test',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        // Langsung buat profil admin terkait (opsional, bisa juga di AdminSeeder)
        Admin::create([
            'user_id' => $adminUser->id,
            'username_admin' => 'adminutama',
        ]);

        // User Dosen
        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budisantoso@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Prof. Siti Aminah',
            'email' => 'sitiaminah@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'email_verified_at' => now(),
        ]);

        // User Mahasiswa
        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andipratama@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Citra Lestari',
            'email' => 'citralestari@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
        ]);

        // Anda bisa menggunakan factory untuk membuat data user yang lebih banyak
        // \App\Models\User::factory(10)->create();
    }
}
