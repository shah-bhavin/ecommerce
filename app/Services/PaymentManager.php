<?php
namespace App\Services;

use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Crypt;

class PaymentManager {
    public static function getConfiguration($slug) {
        $gateway = PaymentGateway::where('slug', $slug)->where('is_active', true)->first();
        if (!$gateway) return null;

        // Decrypt sensitive keys before returning
        return collect($gateway->credentials)->map(function ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value; // Return as is if not encrypted
            }
        })->toArray();
    }
}