<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageCounter extends Model
{
    protected $fillable = [
        'label',
        'value',
        'suffix',
        'icon',
        'rank',
        'status',
    ];
}
