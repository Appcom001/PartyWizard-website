<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'summary', 'description', 'product_weight', 'color', 'material', 'cat_id', 
        'brand_id', 'price', 'vat', 'discount', 'model_number', 'stock', 'size', 'photo'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function getAverageRatingAttribute()
    {
        $averageRating = $this->reviews()->avg('rate');
        return $averageRating ? round($averageRating, 1) : 0;
    }
}