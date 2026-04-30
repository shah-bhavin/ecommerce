<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'address_id', 'order_number', 'shipping_charges', 'subtotal', 'total', 'status', 'payment_method', 'payment_status', 'coupon_id', 'discount_amount'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    
}
