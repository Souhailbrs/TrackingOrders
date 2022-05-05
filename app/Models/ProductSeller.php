<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSeller extends Model
{
    protected $table = 'products_seller';
    protected $fillable = [
        'id',
        'name',
        'received',
        'amount',
        'shop_id',
        'sold',
        'status',
        'seller_id',
        'image'
    ];
    public function seller(){
        return $this->belongsTo(Seller::class,'seller_id');
    }
    public function shop(){
        return $this->belongsTo(SalesChannels::class,'shop_id');
    }
}
