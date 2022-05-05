<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
    protected $table = 'user_work_day';
    protected $fillable = [
        'id',
        'user_type',
        'user_id',
        'started_at',
        'finished_at',
        'completed'
    ];
    public function day_orders(){
        return $this->hasMany(WorkDayOrder::class,'user_user_work_day');
    }
}
