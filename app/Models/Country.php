<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        'title_en',
        'title_ar',
        'currency',
        'currency_symbol'
    ];
    public function cities(){
        return $this->hasMany(City::class,'country_id');
    }
}
