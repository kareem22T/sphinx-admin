<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
    protected $fillable = [
        "icon_path",
        "hotel_id",
    ];

    protected $table = "reasons";
    public $timestamps = false;
    protected $appends = ['reasons_names_as_array', 'reasons_descriptions_as_array'];

    // Relations
    public function hotels()
    {
        return $this->belongsToMany('App\Models\Hotel\Hotel', 'hotel_reasons', 'hotel_id', 'reason_id', 'id', 'id');
    }

    public function names()
    {
        return $this->hasMany('App\Models\ReasonName', 'reason_id');
    }
    public function descriptions()
    {
        return $this->hasMany('App\Models\ReasonDescription', 'reason_id');
    }
    public function getReasonsNamesAsArrayAttribute()
    {
        return $this->names->pluck('name', 'language_id')->toArray();
    }
    public function getReasonsDescriptionsAsArrayAttribute()
    {
        return $this->descriptions->pluck('description', 'language_id')->toArray();
    }
}
