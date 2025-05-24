<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_dosens_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nama', 100);
            $table->string('email_kontak', 255)->nullable(); // Kontak email, bukan untuk login
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->string('no_telp', 20)->nullable();
            $table->boolean('isDosenWali')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
