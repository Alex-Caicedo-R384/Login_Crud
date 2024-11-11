<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $fillable = ['processor_id', 'gpu_id', 'user_id', 'processor_name', 'gpu_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processor()
    {
        return $this->belongsTo(Processor::class, 'processor_id');
    }

    public function gpu()
    {
        return $this->belongsTo(Gpu::class, 'gpu_id');
    }
}



