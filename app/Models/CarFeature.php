<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarFeature extends Model
{
    use HasFactory;
    protected $fillable = [
        "icon_path",
        "name",
    ];

    protected $table = "carfeatures";
    public $timestamps = false;
    protected $appends = ['features_names_as_array'];

    // Relations
    public function cars()
    {
        return $this->belongsToMany('App\Models\Car\Car', 'car_features', 'car_id', 'feature_id', 'id', 'id');
    }

    public function names()
    {
        return $this->hasMany('App\Models\CarFeatureName', 'feature_id');
    }

    public function getFeaturesNamesAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->names->pluck('name', 'language_id')->toArray();
    }
}
