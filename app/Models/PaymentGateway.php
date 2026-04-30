<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'slug', 'credentials', 'is_active', 'is_test_mode', 'sort_order'];

    protected $casts = [
        'credentials' => 'array',
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
    ];

    // Helper to get a specific key securely
    public function getConf($key)
    {
        $value = $this->credentials[$key] ?? '';
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

}
