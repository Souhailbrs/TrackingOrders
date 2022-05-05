<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable
{
    protected $guard = 'delivery';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'zone_id'
    ];
    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id');
    }
}
