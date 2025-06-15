<?php
// database/migrations/xxxx_create_kos_table.php

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
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pemilik kos
            $table->foreignId('kategori_kos_id')->constrained('kategori_kos')->onDelete('cascade');
            $table->foreignId('kota_id')->constrained('kota')->onDelete('cascade');
            $table->string('nama_kos');
            $table->string('alamat');
            $table->text('deskripsi')->nullable();
            $table->integer('harga_per_bulan');
            $table->string('gambar')->nullable(); // Path gambar kos
            $table->integer('jumlah_kamar')->default(1);
            $table->enum('jenis_kos', ['putra', 'putri', 'campur']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};