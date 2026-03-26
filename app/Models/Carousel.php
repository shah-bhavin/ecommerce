<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carousel extends Model
{
    protected $fillable = ['title', 'subtitle', 'image_path', 'link', 'sort_order', 'is_active'];
}
