<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $fillable = ['procesador', 'gpu', 'user_id']; // Asegúrate de agregar 'user_id'

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Relación inversa con el modelo User
    }
}

