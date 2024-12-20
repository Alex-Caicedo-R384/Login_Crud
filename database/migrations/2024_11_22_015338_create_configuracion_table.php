<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->string('resolucion');
            $table->string('preset');
            $table->string('rtx');
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('configuracion');
    }
    
};
