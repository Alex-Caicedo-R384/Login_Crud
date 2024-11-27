<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('benchmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juego_id')->constrained('juegos')->onDelete('cascade'); // Relación con 'juegos'
            $table->foreignId('configuracion_id')->constrained('configuracion')->onDelete('cascade'); // Relación con 'configuracion'
            $table->foreignId('gpu_id')->constrained('gpus')->onDelete('cascade');  // Esta columna se debe agregar aquí
            $table->foreignId('cpu_id')->constrained('processors')->onDelete('cascade');  // Esta columna se debe agregar aquí
            $table->decimal('avg_fps', 5, 2); // Promedio de FPS
            $table->decimal('min_fps', 5, 2); // Mínimo de FPS
            $table->decimal('cpu_usage', 5, 2); // Uso de CPU
            $table->decimal('gpu_usage', 5, 2); // Uso de GPU
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('benchmarks');
    }    
};
