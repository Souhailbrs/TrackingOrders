<?php

namespace App\Models;

use App\Admin\District;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'sales_channele_orders';
    protected $fillable = [
        'id',
        'sales_channel',
        'customer_name',
        'customer_phone1',
        'customer_phone2',
        'customer_notes',
        'notes',
        'country_id',
        'city_id',
        'zone_id',
        'address',
        'district_id',
        'status',
        'delivery_date',
        'deleted',
        'url'
    ];
    public function shop(){
        return $this->belongsTo(SalesChannels::class,'sales_channel');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id');
    }
    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }

    public function product(){
        return $this->hasMany(OrderProduct::class,'sales_channele_order');
    }
    public function track(){
        return $this->hasMany(OrderTrack::class,'sales_channele_order');
    }
    public function getDateTimeAttribute() {
        return date('Y-m-d\TH:i', strtotime($this->delivery_date));
    }

}
