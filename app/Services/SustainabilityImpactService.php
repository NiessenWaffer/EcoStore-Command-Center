<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SustainabilityMetric;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\LocalHub;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SustainabilityImpactService
{
    /**
     * Get monthly aggregated impact data for a user's portfolio.
     */
    public function getUserImpactHistory(User $user): array
    {
        $now = Carbon::now();
        $cutoff = $now->copy()->subMonths(6)->startOfMonth();

        // 1. Get all orders for this user in the last 6 months
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->where('created_at', '>=', $cutoff)
            ->with('items')
            ->get();

        // 2. Group orders by Y-m
        $grouped = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y-m');
        });

        $history = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = $now->copy()->subMonths($i);
            $key = $monthDate->format('Y-m');
            
            $monthOrders = $grouped->get($key) ?? collect();
            
            $water = 0;
            $carbon = 0;

            foreach ($monthOrders as $order) {
                $water += $order->items->sum('water_saved_at_purchase');
                $carbon += $order->items->sum('carbon_reduced_at_purchase');
            }

            $history[] = [
                'month' => $monthDate->format('M'),
                'water' => (float) $water,
                'carbon' => (float) $carbon,
            ];
        }

        return $history;
    }

    /**
     * Calculate transit impact based on distance and mode.
     */
    public function calculateTransitImpact(LocalHub $hub, string $destinationZip): array
    {
        $geoService = app(GeoRoutingService::class);
        
        // Technical Note: Zip-to-Coord would happen here. 
        // For MVP, we simulate the destination coord based on Zip length for variance.
        $destLat = $hub->latitude + (strlen($destinationZip) / 100);
        $destLng = $hub->longitude + (strlen($destinationZip) / 100);

        $distanceKm = $geoService->calculateDistance(
            $hub->latitude, 
            $hub->longitude, 
            $destLat, 
            $destLng
        );

        $isInternational = $distanceKm > 1000;
        $factor = $isInternational ? 0.5 : 0.05; // Air vs Land

        $co2 = round($distanceKm * $factor, 2);
        $offsetFee = round($co2 * 0.15, 2);

        return [
            'distance_km' => $distanceKm,
            'co2_penalty' => $co2,
            'regeneration_fee' => $offsetFee,
            'is_international' => $isInternational,
            'sourcing_hub' => $hub->name,
        ];
    }

    /**
     * Calculate the environmental impact for a specific product variant.
     * Logic: Sum(Variant Weight * Material % * Material Coefficient)
     */
    public function calculateVariantImpact(ProductVariant $variant): array
    {
        $product = $variant->product;
        $composition = $product->material_composition ?? []; // Key-Value: ['Material' => Percent]
        $weight = $variant->physical_weight_kg;

        $waterSaved = 0;
        $carbonReduced = 0;

        foreach ($composition as $material => $percent) {
            $metric = SustainabilityMetric::where('material_type', $material)->first();
            
            if ($metric) {
                $multiplier = ($percent / 100) * $weight;
                $waterSaved += $multiplier * $metric->water_per_kg;
                $carbonReduced += $multiplier * $metric->carbon_per_kg;
            }
        }

        return [
            'water_saved' => round($waterSaved, 0),
            'carbon_reduced' => round($carbonReduced, 2),
            'impact_index' => $this->calculateImpactIndex($waterSaved, $carbonReduced),
            'tier_label' => $this->getTierLabel($waterSaved, $carbonReduced),
            'score' => $product->sustainability_score,
        ];
    }

    /**
     * Calculate a professional 0-100 Impact Index.
     */
    public function calculateImpactIndex(float $water, float $carbon): int
    {
        // Formula: Weight water and carbon savings against a perfect score (e.g. 5000L and 50kg)
        $waterScore = min(100, ($water / 2000) * 100);
        $carbonScore = min(100, ($carbon / 20) * 100);
        
        return (int) round(($waterScore * 0.6) + ($carbonScore * 0.4));
    }

    /**
     * Get a professional Tier Label based on impact index.
     */
    public function getTierLabel(float $water, float $carbon): string
    {
        $index = $this->calculateImpactIndex($water, $carbon);

        if ($index >= 90) return 'Regenerative';
        if ($index >= 70) return 'Circular Prime';
        if ($index >= 50) return 'Standard';
        
        return 'Emerging';
    }

    /**
     * Get real-world equivalencies for raw metrics.
     */
    public function getEquivalencies(float $water, float $carbon): array
    {
        return [
            'showers' => round($water / 50, 1),
            'miles_driven' => round($carbon * 2.5, 1),
            'drinking_water_days' => round($water / 2, 0),
        ];
    }
}
