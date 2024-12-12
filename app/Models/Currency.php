<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        "code",
        "name"
    ];

    public $table = "currencies";

    public function names()
    {
        return $this->hasMany('App\Models\CurrencyName', 'currency_id');
    }
    protected $appends = ['currency_names_as_array'];

    public function getCurrencyNamesAsArrayAttribute()
    {
        // Transform the related names into an array of [language_id => name]
        return $this->names->pluck('name', 'language_id')->toArray();
    }

}
