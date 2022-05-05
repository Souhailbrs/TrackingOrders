<?php

namespace App\Models;

use App\Admin\District;
use Illuminate\Database\Eloquent\Model;

class SalesChannels extends Model
{
    protected $table = 'sales_channels';
    protected $fillable = [
        'id',
        'title_en',
        'title_ar',
        'shop_url',
        'owner_email',
        'owner_password',
        'owner_phone',
        'sales_channel_type_id',
        'city_id',
        'country_id',
        'status'
    ];

    public function shopType(){
        return $this->belongsTo(SalesChannelsType::class,'sales_channel_type_id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id');
    }
    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }
    public function products(){
        return $this->hasMany(Inventory::class,'sales_channel_id');
    }
    public function orders(){
        return $this->hasMany(Order::class,'sales_channel');
    }

}
