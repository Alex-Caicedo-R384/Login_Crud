<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ajustes_recomendados', function (Blueprint $table) {
            $table->id();
            $table->string('categoria')->unique();
            $table->integer('min_fps')->nullable();
            $table->integer('max_fps')->nullable();
            $table->string('recommended_resolution');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ajustes_recomendados');
    }
};
