<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdmin extends Authenticatable
{
    protected $guard = 'super-admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status'
    ];
}
