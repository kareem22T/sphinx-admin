<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Car extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $fillable = [
        "id",
        "phone",
        "lat",
        "lng",
        "address",
        "address_name"
    ];
    public function titles()
    {
        return $this->hasMany('App\Models\Car\Title', 'car_id');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Car\Price', 'car_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\Car\Description', 'car_id');
    }
    public function types()
    {
        return $this->hasMany('App\Models\Car\Type', 'car_id');
    }

    public function features()
    {
        return $this->belongsToMany('App\Models\CarFeature', 'car_features', 'car_id', 'feature_id', 'id', 'id');
    }

    protected $appends = ['car_titles_as_array', 'car_descriptions_as_array', 'car_types_as_array', 'package_prices_as_array', 'gallery'];

    public function getCarTitlesAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->titles->pluck('title', 'language_id')->toArray();
    }
    public function getCarDescriptionsAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->descriptions->pluck('description', 'language_id')->toArray();
    }
    public function getCarTypesAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->types->pluck('type', 'language_id')->toArray();
    }
    public function getPackagePricesAsArrayAttribute()
    {
        return $this->prices->pluck('price', 'currency_id')->toArray();
    }

    public function getGalleryAttribute()
    {
        $media =  $this->media->map(function ($mediaItem) {
            return [
                'path' => $mediaItem->id . '/' . $mediaItem->file_name,
            ];
        });

        return $media;
    }
}
