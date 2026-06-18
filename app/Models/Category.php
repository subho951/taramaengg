<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'category_name',
        'slug',
        'cover_image',
        'banner_image',
        'short_description',
        'description',
        'is_feature',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    protected $casts = [
        'is_feature' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'main_category');
    }
}
