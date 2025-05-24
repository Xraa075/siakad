<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frs_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_nrp', 20);
            $table->foreign('mahasiswa_nrp')->references('nrp')->on('mahasiswas')->onDelete('cascade');
            $table->foreignId('matakuliah_id')->constrained('matakuliahs')->onDelete('cascade');
            $table->integer('semester');
            $table->enum('status', ['acc', 'belum acc'])->default('belum acc');
            $table->date('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frs_mahasiswas');
    }
};
