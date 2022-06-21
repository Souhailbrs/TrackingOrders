<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'is_super_admin',
        'country_id'
    ];
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
}
