<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_admins_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('username_admin', 50);
            $table->timestamps(); // created_at dan updated_at (NULL DEFAULT NULL)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
