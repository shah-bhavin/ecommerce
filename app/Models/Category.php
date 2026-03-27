<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','slug', 'description','image', 'is_active', 'is_featured', 'meta_title', 'meta_description'];

    // public function parent(): BelongsTo 
    // {
    //     return $this->belongsTo(Category::class, 'parent_id');
    // }

    // public function children(): HasMany
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }

    // Scope for active categories only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
