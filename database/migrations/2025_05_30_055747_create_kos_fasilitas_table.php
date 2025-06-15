<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKosFasilitasTable extends Migration
{
    public function up()
    {
        Schema::create('kos_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kos_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->timestamps();

            $table->foreign('kos_id')->references('id')->on('kos')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');

            $table->unique(['kos_id', 'fasilitas_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kos_fasilitas');
    }
}
