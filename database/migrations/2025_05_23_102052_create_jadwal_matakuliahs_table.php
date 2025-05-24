<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_matakuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_kuliah_id')->constrained('jadwal_kuliahs')->onDelete('cascade');
            $table->foreignId('matakuliah_id')->constrained('matakuliahs')->onDelete('cascade');
            $table->string('dosen_nip', 20); // Dosen Pengajar 1
            $table->foreign('dosen_nip')->references('nip')->on('dosens')->onDelete('cascade');
            $table->string('dosen_pengajar2_nip', 20)->nullable();
            $table->foreign('dosen_pengajar2_nip')->references('nip')->on('dosens')->onDelete('set null');
            $table->string('hari', 10);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan', 50);
            $table->integer('semester');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_matakuliahs');
    }
};
