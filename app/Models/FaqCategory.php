<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FaqCategory extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faq_categories'
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
        
    // ];
}
