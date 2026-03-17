<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    public $fillable = ['code', 'type', 'value', 'min_order_amount', 'usage_limit', 'used_count', 'expiry_date', 'is_active'];
}
