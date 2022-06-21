<?php

namespace App\Models;

use App\Admin\District;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    protected $fillable = [
        'id',
        'title_en',
        'title_ar',
        'description',
        'from',
        'to',
        'city_id'
    ];
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function delivery(){
        return $this->hasOne(Delivery::class,'zone_id');
    }
    public function districts(){
        return $this->hasMany(District::class,'zone_id');
    }

}
