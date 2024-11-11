<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('computers', function (Blueprint $table) {
            $table->foreignId('processor_id')->default(1)->constrained()->onDelete('cascade');  // Ajusta el valor por defecto a un ID válido
            $table->foreignId('gpu_id')->default(1)->constrained()->onDelete('cascade');  // Ajusta el valor por defecto a un ID válido
        });
    }
    
    
    public function down()
    {
        Schema::table('computers', function (Blueprint $table) {
            $table->dropForeign(['processor_id']);
            $table->dropForeign(['gpu_id']);
            $table->dropColumn(['processor_id', 'gpu_id']);
        });
    }    
};
