<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    protected $table = 'orders_log';
    protected $fillable =[
        'seller_id',
        'order_id',
        'status'
    ];
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function seller(){
        return $this->belongsTo(Seller::class,'seller_id');
    }
}
