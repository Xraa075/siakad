<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('frs_mahasiswas', function (Blueprint $table) {
            $table->boolean('available')->default(true)->after('tanggal_pengajuan');
        });
    }

    public function down(): void
    {
        Schema::table('frs_mahasiswas', function (Blueprint $table) {
            $table->dropColumn('available');
        });
    }
};
