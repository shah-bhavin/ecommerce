<?php
namespace App\Services;

use App\Models\ShippingRule;

class ShippingCalculator
{
    public static function getFee($orderTotal)
    {
        // Get rules sorted by threshold (lowest to highest)
        $rules = ShippingRule::where('is_active', true)
            ->orderBy('threshold', 'asc')
            ->get();

        foreach ($rules as $rule) {
            if ($orderTotal < $rule->threshold) {
                return $rule->fee;
            }
        }

        // If it exceeds the highest threshold, shipping is free (0)
        return 0;
    }

    public static function getNextThreshold($orderTotal)
    {
        return ShippingRule::where('is_active', true)
            ->where('threshold', '>', $orderTotal)
            ->orderBy('threshold', 'asc')
            ->first();
    }
}