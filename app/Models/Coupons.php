<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $fillable = [
        "coupon_code",
        "discount_percentage",
        "start_date",
        "end_date",
        "hotel_id",
        "tour_id",
    ];
}
