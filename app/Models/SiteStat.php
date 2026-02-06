<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStat extends Model
{
    //
    protected $fillable = [
        'date',
        'visits',
        'page_views',
        'total_duration',
    ];
}
