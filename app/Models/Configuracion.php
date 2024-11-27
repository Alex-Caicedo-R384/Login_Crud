<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuracion';

    protected $fillable = ['resolucion', 'preset', 'rtx', 'juego_id'];

    public function juegos()
    {
        return $this->belongsToMany(Juego::class, 'juego_configuracion');
    }

    public function benchmarks()
    {
        return $this->hasMany(Benchmark::class);
    }
}

