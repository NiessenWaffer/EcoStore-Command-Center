<?php

namespace Database\Factories;

use App\Models\ProductPassport;
use App\Models\Product;
use App\Models\Factory;
use Illuminate\Database\Eloquent\Factories\Factory as BaseFactory;
use Illuminate\Support\Str;

class ProductPassportFactory extends BaseFactory
{
    protected $model = ProductPassport::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'batch_number' => 'BATCH-' . $this->faker->unique()->numberBetween(1000, 9999),
            'factory_id' => Factory::factory(),
            'transit_impact_carbon' => 0.5,
            'manufacturing_date' => now()->subDays(10),
            'qr_token' => Str::random(64),
            'is_verified' => false,
            'last_audit_hash' => null,
        ];
    }
}
