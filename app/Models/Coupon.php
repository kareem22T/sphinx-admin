<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        "coupon_code",
        "title",
        "description",
        "discount_percentage",
        "start_date",
        "end_date",
        'hotels',
        'tours',
    ];

    protected $casts = [
        'hotels' => 'array',
        'tours' => 'array'
    ];
}
