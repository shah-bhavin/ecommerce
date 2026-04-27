<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingRule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'label',
        'threshold',        
        'fee',
        'priority',
        'is_active'       
    ];
}
