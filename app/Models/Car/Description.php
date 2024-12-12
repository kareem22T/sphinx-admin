<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    use HasFactory;
    protected $fillable = [
        "description",
        "car_id",
        "language_id",
    ];

    protected $table = "car_descriptions";
    public $timestamps = false;
    
    //Relations 
    public function car()
    {
        return $this->belongsTo('App\Models\Car\Car', 'car_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language', 'language_id');
    }
}
