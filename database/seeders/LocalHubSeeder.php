<?php

namespace Database\Seeders;

use App\Models\LocalHub;
use Illuminate\Database\Seeder;

class LocalHubSeeder extends Seeder
{
    public function run(): void
    {
        $hubs = [
            [
                'name' => 'Eco-Hub North',
                'address' => '123 Green Lane',
                'city' => 'Springfield',
                'postal_code' => '12345',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'supports_naked_shipping' => true,
            ],
            [
                'name' => 'Downtown Green Point',
                'address' => '456 Sustain Blvd',
                'city' => 'Springfield',
                'postal_code' => '12346',
                'latitude' => 40.7306,
                'longitude' => -73.9352,
                'supports_naked_shipping' => true,
            ],
            [
                'name' => 'East Side Micro-Hub',
                'address' => '789 Nature St',
                'city' => 'Springfield',
                'postal_code' => '12347',
                'latitude' => 40.7589,
                'longitude' => -73.9851,
                'supports_naked_shipping' => false,
            ],
        ];

        foreach ($hubs as $hub) {
            LocalHub::firstOrCreate(['name' => $hub['name']], $hub);
        }
    }
}
