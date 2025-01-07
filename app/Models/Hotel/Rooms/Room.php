<?php

namespace App\Models\Hotel\Rooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Room extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        "id",
        "hotel_id",
    ];

    //Relations
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel\Hotel', 'hotel_id');
    }

    public function names()
    {
        return $this->hasMany('App\Models\Hotel\Rooms\Name', 'room_id');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Hotel\Rooms\Price', 'room_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\Hotel\Rooms\Description', 'room_id');
    }
    public function features()
    {
        return $this->belongsToMany('App\Models\Feature', 'room_features', 'room_id', 'feature_id', 'id', 'id');
    }

    protected $appends = ['room_names_as_array', 'room_descriptions_as_array', 'gallery'];

    public function getRoomNamesAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->names->pluck('name', 'language_id')->toArray();
    }

    public function getRoomDescriptionsAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->descriptions->pluck('description', 'language_id')->toArray();
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
