<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    public $fillable = ['sku', 'size', 'color', 'price_modifier', 'stock_quantity', 'variant_image'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper to get total price
    public function getFinalPriceAttribute()
    {
        return $this->product->base_price + $this->price_modifier;
    }
}
