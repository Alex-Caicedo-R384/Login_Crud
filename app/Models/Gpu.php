<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpu extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function computers()
    {
        return $this->hasMany(Computer::class);
    }
}



