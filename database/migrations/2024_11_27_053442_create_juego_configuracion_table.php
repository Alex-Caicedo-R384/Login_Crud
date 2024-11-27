<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('juego_configuracion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juego_id')->constrained('juegos')->onDelete('cascade');
            $table->foreignId('configuracion_id')->constrained('configuracion')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('juego_configuracion');
    }
};
