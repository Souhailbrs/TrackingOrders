<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'sales_orders_products';
    protected $fillable = [
        'sales_channele_order',
        'product_id',
        'amount',
        'price',
    ];
    public function one_product(){
        return $this->belongsTo(ProductSeller::class,'product_id');
    }
}
