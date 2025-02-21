<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    protected $fillable = [
        'text_ar',
        'text',
        'thumbnail',
        'video',
    ];
}
