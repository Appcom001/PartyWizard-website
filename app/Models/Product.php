<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'description',
        'photo',
        'stock',
        'size',
        'price',
        'vat',
        'discount',
        'color',
        'model_number',
        'product_weight',
        'cat_id',
        'brand_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * حساب متوسط التقييمات للمنتج.
     *
     * @return float
     */
    public function getAverageRatingAttribute()
    {
        $averageRating = $this->reviews()->avg('rate');
        return $averageRating ? round($averageRating, 1) : 0;
    }
}