<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocalHub;

class GlobalHubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hubs = [
            [
                'name' => 'London Circular Center',
                'region_code' => 'EU',
                'address' => '123 Kings Road',
                'city' => 'London',
                'postal_code' => 'SW3 4TR',
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'timezone' => 'Europe/London',
            ],
            [
                'name' => 'NYC Innovation Hub',
                'region_code' => 'US',
                'address' => '456 Broadway',
                'city' => 'New York',
                'postal_code' => '10013',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'timezone' => 'America/New_York',
            ],
            [
                'name' => 'Tokyo Precision Hub',
                'region_code' => 'JP',
                'address' => '7-8-9 Ginza',
                'city' => 'Tokyo',
                'postal_code' => '104-0061',
                'latitude' => 35.6762,
                'longitude' => 139.6503,
                'timezone' => 'Asia/Tokyo',
            ],
            [
                'name' => 'Berlin Eco-Node',
                'region_code' => 'EU',
                'address' => '10 Friedrichstraße',
                'city' => 'Berlin',
                'postal_code' => '10117',
                'latitude' => 52.5200,
                'longitude' => 13.4050,
                'timezone' => 'Europe/Berlin',
            ],
        ];

        foreach ($hubs as $hub) {
            LocalHub::updateOrCreate(
                ['name' => $hub['name']],
                $hub
            );
        }
    }
}
