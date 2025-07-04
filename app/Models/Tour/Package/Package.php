<?php

namespace App\Models\Tour\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        "tour_id",
    ];

    protected $table = "tour_packages";
    public $timestamps = false;

    //Relations
    public function tour()
    {
        return $this->belongsTo('App\Models\Tour\Tour', 'tour_id');
    }
    public function titles()
    {
        return $this->hasMany('App\Models\Tour\Package\Title', 'package_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\Tour\Package\Description', 'package_id');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Tour\Package\Price', 'package_id');
    }

    public function points()
    {
        return $this->hasMany('App\Models\Tour\Package\Point', 'package_id');
    }

    protected $appends = [
        'package_titles_as_array',
        'package_descriptions_as_array',
        'package_prices_as_array',
    ];

    public function getPackageTitlesAsArrayAttribute()
    {
        return $this->titles->pluck('title', 'language_id')->toArray();
    }
    public function getPackageDescriptionsAsArrayAttribute()
    {
        return $this->descriptions->pluck('description', 'language_id')->toArray();
    }

    public function getPackagePricesAsArrayAttribute()
    {
        return $this->prices->pluck('price', 'currency_id')->toArray();
    }

    public function getFirstTitleAttribute()
    {
        return $this->titles->first()?->title; // Safely fetch the first title
    }
}
