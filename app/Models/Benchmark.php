<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benchmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'juego_id',
        'configuracion_id',
        'gpu_id',
        'cpu_id',
        'avg_fps',
        'min_fps',
        'cpu_usage',
        'gpu_usage',
        'categoria',
        'user_id',
    ];

    public function configuracion()
    {
        return $this->belongsTo(Configuracion::class);
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }

    public function gpu()
    {
        return $this->belongsTo(Gpu::class);
    }

    public function processor()
    {
        return $this->belongsTo(Processor::class, 'cpu_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relación con el modelo User
    }
}
