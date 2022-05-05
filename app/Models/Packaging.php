<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Packaging extends Authenticatable
{
    protected $guard = 'packagings';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status'
    ];

}
