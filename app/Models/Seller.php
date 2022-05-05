<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    protected $guard = 'seller';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status'
    ];

}
