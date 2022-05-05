<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    protected $table = 'sales_orders_tracks';
    protected $fillable = [
        'sales_channele_order',
        'old_status',
        'last_status',
        'changes'
    ];
}
