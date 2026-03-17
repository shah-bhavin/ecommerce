<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',        
        'quantity',
        'price_at_purchase'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
