<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    public const STATUSES = [
        'NEW' => 'New',
        'REVIEWED' => 'Reviewed',
        'SHORTLISTED' => 'Shortlisted',
        'CONTACTED' => 'Contacted',
        'REJECTED' => 'Rejected',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'experience',
        'message',
        'resume',
        'status',
    ];
}
