<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'main_category',
        'name',
        'slug',
        'cover_image',
        'short_description',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'main_category');
    }
}
