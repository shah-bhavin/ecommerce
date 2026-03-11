<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'fullname', 'phone', 'house_no', 'area', 
        'landmark', 'city', 'state', 'pincode', 'type', 'is_default'
    ];

    protected $table = 'addresses';


    public function user() {
        return $this->belongsTo(User::class);
    }
}
