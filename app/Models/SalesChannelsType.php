<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesChannelsType extends Model
{
    protected $table = 'sales_channels_types';
    protected $fillable = [
        'title_en',
        'title_ar',
        'status'
    ];
    public function shops(){
        return $this->hasMany(SalesChannels::class,'sales_channel_type_id');
    }
}
