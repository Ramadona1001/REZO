<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'id','name','descriptions','slaray_range','created_by'
    ];

    
}
