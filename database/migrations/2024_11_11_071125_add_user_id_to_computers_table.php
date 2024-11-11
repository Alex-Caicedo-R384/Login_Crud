<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToComputersTable extends Migration
{
    /**
     * Ejecuta las modificaciones de la base de datos.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('computers', function (Blueprint $table) {
            // Agregar la columna user_id como clave foránea
            $table->unsignedBigInteger('user_id')->after('gpu');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            // Eliminar la columna user_id y su restricción de clave foránea
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
