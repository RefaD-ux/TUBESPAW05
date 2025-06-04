<?php
// database/migrations/xxxx_create_favorites_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengguna yang memfavoritkan
            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade'); // Kos yang difavoritkan
            $table->timestamps();

            // Agar satu kos hanya bisa difavoritkan sekali oleh satu pengguna
            $table->unique(['user_id', 'kos_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};

?>
