<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteRecomendado extends Model
{
    use HasFactory;

    protected $table = 'ajustes_recomendados';

    protected $fillable = ['categoria', 'min_fps', 'max_fps', 'recommended_resolution', 'user_id'];

    public function juego()
    {
        return $this->belongsTo(Juego::class, 'categoria', 'categoria');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
