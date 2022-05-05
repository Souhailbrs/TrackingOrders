<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJoinRequest extends Model
{
    protected $table = 'user_join_requests';
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'password',
        'subject',
        'message',
        'state',
        'notes',
        'file',
        'times'
    ];
}
