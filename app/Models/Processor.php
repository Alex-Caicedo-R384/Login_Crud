<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processor extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function computers()
    {
        return $this->hasMany(Computer::class); // Relación uno a muchos
    }
}


