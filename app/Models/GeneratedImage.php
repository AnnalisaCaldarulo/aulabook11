<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedImage extends Model
{
    use HasFactory;

    protected $fillable = ['prompt', 'image'];
}
