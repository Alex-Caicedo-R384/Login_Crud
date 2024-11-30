<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'categoria'];

    public function configuraciones()
    {
        return $this->belongsToMany(Configuracion::class, 'juego_configuracion');
    }

    public function benchmarks()
    {
        return $this->hasMany(Benchmark::class);
    }

    public function ajustesRecomendados()
    {
        return $this->hasOne(AjusteRecomendado::class, 'categoria', 'categoria');
    }

}
