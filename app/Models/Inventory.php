<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'sales_channele_inventory';
    protected $fillable = [
        'sales_channel_id',
        'shop_category',
        'product_name',
        'company_name',
        'company_number',
        'country_sent',
        'delivery_type',
        'boxes_number',
        'product_amount',
        'Expected_time',
        'Actual_time',
        'sold',
        'status',
        'created_at'
    ];
    public function shop(){
        return $this->belongsTo(SalesChannels::class,'sales_channel_id');
    }
    public function product(){
        return $this->belongsTo(ProductSeller::class,'product_name');

    }
}
