<?php

namespace App\Models\Tour\Day;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        "thumbnail",
        "tour_id",
    ];

    protected $table = "tour_days";
    public $timestamps = false;

    //Relations
    public function tour()
    {
        return $this->belongsTo('App\Models\Tour\Tour', 'tour_id');
    }
    public function titles()
    {
        return $this->hasMany('App\Models\Tour\Day\Title', 'day_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\Models\Tour\Day\Description', 'day_id');
    }

    protected $appends = [
        'day_titles_as_array',
        'day_descriptions_as_array',
    ];

    public function getDayTitlesAsArrayAttribute()
    {
        return $this->titles->pluck('title', 'language_id')->toArray();
    }
    public function getDayDescriptionsAsArrayAttribute()
    {
        return $this->descriptions->pluck('description', 'language_id')->toArray();
    }

    public function getFirstTitleAttribute()
    {
        return $this->titles->first()?->title; // Safely fetch the first title
    }
}
