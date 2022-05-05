<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderContact extends Model
{
    protected $table ='orders_contact';
    protected $fillable = [
        'sale_channele_order_id',
        'times',
        'status',
        'user_id',
        'userType',
        'created_at',
        'updated_at',

    ];
}
