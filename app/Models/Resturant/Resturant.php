<?php

namespace App\Models\Resturant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{
    use HasFactory;

    protected $fillable = [
        "thumbnail",
        "address",
        "address_name",
        "lat",
        "lng",
    ];

    protected $table = "resturants";
    public $timestamps = false;
    protected $appends = [
        'resturants_titles_as_array',
        'resturants_descriptions_as_array',
        'first_name',
    ];

    //Relations
    public function titles()
    {
        return $this->hasMany('App\Models\Resturant\Title', 'resturant_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\Resturant\Description', 'resturant_id');
    }
    public function getFirstNameAttribute()
    {
        return $this->titles()->first()->title; // Safely fetch the first name of the destination
    }

    public function getResturantsTitlesAsArrayAttribute()
    {
        return $this->titles->pluck('title', 'language_id')->toArray();
    }


    public function getResturantsDescriptionsAsArrayAttribute()
    {
        return $this->descriptions->pluck('description', 'language_id')->toArray();
    }
}
