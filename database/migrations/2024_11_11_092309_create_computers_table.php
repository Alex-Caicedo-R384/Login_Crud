<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processor_id')->constrained('processors')->onDelete('cascade');
            $table->string('processor_name'); // Agregar campo para el nombre del procesador
            $table->foreignId('gpu_id')->constrained('gpus')->onDelete('cascade');
            $table->string('gpu_name'); // Agregar campo para el nombre de la GPU
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }    

    public function down()
    {
        Schema::dropIfExists('computers');
    }
};
