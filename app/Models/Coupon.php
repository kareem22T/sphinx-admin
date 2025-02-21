<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        "coupon_code",
        "description",
        "discount_percentage",
        "start_date",
        "end_date",
        "hotel_id",
        "tour_id",
    ];
}
