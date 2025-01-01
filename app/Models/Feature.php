<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $fillable = [
        "icon_path",
        "name"
    ];

    protected $table = "features";
    public $timestamps = false;
    protected $appends = ['features_names_as_array'];

    // Relations
    public function hotels()
    {
        return $this->belongsToMany('App\Models\Hotel\Hotel', 'hotel_features', 'hotel_id', 'feature_id', 'id', 'id');
    }

    public function names()
    {
        return $this->hasMany('App\Models\FeatureName', 'feature_id');
    }

    public function getFeaturesNamesAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->names->pluck('name', 'language_id')->toArray();
    }
}
