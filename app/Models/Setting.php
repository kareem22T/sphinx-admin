<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotels',
        'tours',
        'ad_image',
        'ad_title_en',
        'ad_title_ar',
        'ad_description_en',
        'ad_description_ar',
        'ad2_image',
        'ad2_title_en',
        'ad2_title_ar',
        'ad2_description_en',
        'ad2_description_ar',
        'main_image',
    ];
}
