<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('juegos', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('nombre');
        });

        Schema::table('benchmarks', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('gpu_usage');
        });
    }

    public function down()
    {
        Schema::table('juegos', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });

        Schema::table('benchmarks', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
    }
};
