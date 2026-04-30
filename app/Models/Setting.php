<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',        
    ];

    // App\Models\Setting.php
    public static function get($key, $default = null) {
        return cache()->rememberForever("setting.{$key}", function () use ($key, $default) {
            return self::where('key', $key)->first()?->value ?? $default;
        });
    }
}

