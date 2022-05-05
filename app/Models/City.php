<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'title_en',
        'title_ar',
        'country_id'
    ];
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
}
