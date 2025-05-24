<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_matakuliahs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_matakuliah', 100);
            $table->string('dosen_nip', 20); // Dosen PJMK
            $table->foreign('dosen_nip')->references('nip')->on('dosens')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->integer('semester');
            $table->integer('sks');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matakuliahs');
    }
};
