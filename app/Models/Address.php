<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'fullname', 'phone', 'house_no', 'area', 
        'landmark', 'city', 'state', 'pincode', 'type', 'is_default'
    ];

    protected $table = 'addresses';


    public function user() {
        return $this->belongsTo(User::class);
    }
}
