<?php

namespace App\Services;

use App\Models\LocalHub;
use Illuminate\Support\Collection;

class GeoRoutingService
{
    /**
     * Detect region code from IP.
     */
    public function detectRegion(string $ip): string
    {
        // Mocking for MVP (Localhost always US for now)
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'US';
        }

        // In production: return Http::get("https://ipstack.com/...")['region_code']
        return 'EU'; 
    }

    /**
     * Find the nearest hub using Haversine formula.
     */
    public function getNearestHub(float $lat, float $lng): ?LocalHub
    {
        $hubs = LocalHub::all();
        
        if ($hubs->isEmpty()) return null;

        return $hubs->map(function ($hub) use ($lat, $lng) {
            $hub->distance = $this->calculateDistance($lat, $lng, $hub->latitude, $hub->longitude);
            return $hub;
        })->sortBy('distance')->first();
    }

    /**
     * Haversine formula to calculate distance in km between two coordinates.
     */
    public function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }
}
