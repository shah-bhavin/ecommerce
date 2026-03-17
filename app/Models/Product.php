<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description', 'price', 'category', 'skin_type', 'stock', 'image', 'meta_title', 'meta_description'];

    protected function casts(): array {
        return [ 'price' => 'decimal:2' ];
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function averageRating() {
        return round($this->reviews()->where('is_active', true)->avg('rating'), 1);
    }

}
