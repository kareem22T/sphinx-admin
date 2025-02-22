<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tour extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        "expired_date",
        "duration",
        "min_participant",
        "max_participant",
        "avg_rating",
        "num_of_ratings",
        "destination_id",
        "lowest_package_price",
        "price_type"
    ];

    public $table = "tours";

    // Relations
    public function titles()
    {
        return $this->hasMany('App\Models\Tour\Title', 'tour_id');
    }

    public function intros()
    {
        return $this->hasMany('App\Models\Tour\Intro', 'tour_id');
    }

    public function locations()
    {
        return $this->hasMany('App\Models\Tour\Location', 'tour_id');
    }

    public function transportations()
    {
        return $this->hasMany('App\Models\Tour\Transportation', 'tour_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\Tour\Description', 'tour_id');
    }

    public function includes()
    {
        return $this->hasMany('App\Models\Tour\IncludeModel', 'tour_id');
    }

    public function excludes()
    {
        return $this->hasMany('App\Models\Tour\Exclude', 'tour_id');
    }

    public function days()
    {
        return $this->hasMany('App\Models\Tour\Day\Day', 'tour_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Models\Tour\Package\Package', 'tour_id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Tour_rating', 'tour_id');
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Destination', 'destination_id');
    }
    public function activities()
    {
        return $this->belongsToMany('App\Models\Activity', 'tour_activities', 'tour_id', 'activity_id', 'id', 'id');
    }

    protected $appends = [
        'tours_titles_as_array',
        'intros_as_array',
        'locations_as_array',
        'transportation_as_array',
        'includes_as_array',
        'excludes_as_array',
        'first_name',
        'gallery',
    ];

    public function getToursTitlesAsArrayAttribute()
    {
        return $this->titles->pluck('title', 'language_id')->toArray();
    }

    public function getIntrosAsArrayAttribute()
    {
        return $this->intros->pluck('intro', 'language_id')->toArray();
    }

    public function getLocationsAsArrayAttribute()
    {
        return $this->locations->pluck('location', 'language_id')->toArray();
    }

    public function getTransportationAsArrayAttribute()
    {
        return $this->transportations->pluck('transportation', 'language_id')->toArray();
    }

    public function getIncludesAsArrayAttribute()
    {
        return $this->includes->pluck('include', 'language_id')->toArray();
    }

    public function getExcludesAsArrayAttribute()
    {
        return $this->excludes->pluck('exclude', 'language_id')->toArray();
    }

    public function getFirstNameAttribute()
    {
        return $this->titles()->first()?->title; // Safely fetch the first name of the destination
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
