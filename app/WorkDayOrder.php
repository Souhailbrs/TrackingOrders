<?php

namespace App;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;

class WorkDayOrder extends Model
{
    protected $table = 'user_work_day_orders';
    protected $fillable = [
        'user_user_work_day',
        'user_sales_channele_orders',
        'order_status_from',
        'order_status_to',
        'userType',
        'userID',
        'status'
    ];
    public function order(){
        return $this->belongsTo(Order::class,'user_sales_channele_orders');
    }

}
