<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'logo', 
        'is_active', 
        'meta_title',
        'meta_description'
    ];
}
