<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $fillable = ['code', 'type', 'value', 'min_order_amount', 'usage_limit', 'used_count', 'expiry_date', 'is_active'];
}
