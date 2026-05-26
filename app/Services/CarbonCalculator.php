<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class CarbonCalculator
{
    /**
     * Calculate the carbon cost of returning a specific order item.
     * Factors: weight, distance (fixed average for MVP), and double-shipping (return + processing).
     */
    public function calculateReturnCost(OrderItem $item): float
    {
        // Average CO2 per kg for domestic shipping is ~0.5kg CO2
        // Return journey + Processing warehouse overhead = factor of 1.5x
        $weight = $item->variant->physical_weight_kg ?? 0.5;
        $baseReturnCarbon = $weight * 0.5; 
        
        return round($baseReturnCarbon * 1.5, 2);
    }

    /**
     * Calculate total return carbon for multiple items.
     */
    public function calculateTotalReturnCarbon(array $itemIds): float
    {
        $items = OrderItem::whereIn('id', $itemIds)->with('variant')->get();
        $total = 0;

        foreach ($items as $item) {
            $total += $this->calculateReturnCost($item);
        }

        return round($total, 2);
    }
}
