<?php

namespace App\Admin;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $fillable = [
      'title_en',
      'title_ar',
      'zone_id'
    ];
    public  function zone(){
        return $this->belongsTo(Zone::class,'zone_id');
    }
}
