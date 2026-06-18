<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    protected $fillable = [
        'name',
        'website_url',
        'logo',
        'rank',
        'status',
    ];
}
