<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingSection extends Model
{
    protected $table = 'landing_sections';
    protected $fillable=[
      'section',
      'field',
      'value'
    ];
}
