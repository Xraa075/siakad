<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('frs_mahasiswas', function (Blueprint $table) {
            $table->enum('status', ['acc', 'belum acc'])->default('belum acc')->change(); // pastikan ini diubah kalau belum
            $table->enum('status_ambil', ['ambil', 'belum ambil'])->default('belum ambil')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('frs_mahasiswas', function (Blueprint $table) {
            $table->dropColumn('status_ambil');
        });
    }
};
