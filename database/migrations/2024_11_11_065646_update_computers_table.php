<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateComputersTable extends Migration
{
    /**
     * Ejecuta las modificaciones de la base de datos.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('computers', function (Blueprint $table) {
            // Eliminar las columnas innecesarias
            $table->dropColumn('modulos_ram');
            $table->dropColumn('capacidad_ram');
        });
    }

    /**
     * Revierte las modificaciones de la base de datos.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('computers', function (Blueprint $table) {
            // Volver a agregar las columnas si fuera necesario revertir la migración
            $table->string('modulos_ram');
            $table->string('capacidad_ram');
        });
    }
}
