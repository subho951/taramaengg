<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyUsPoint extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'rank',
        'status',
    ];
}
