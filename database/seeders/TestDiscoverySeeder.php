<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SustainabilityMetric;

class TestDiscoverySeeder extends Seeder
{
    public function run(): void
    {
        $metric = SustainabilityMetric::updateOrCreate(
            ['material_type' => 'Organic Cotton'],
            ['water_per_kg' => 2000, 'carbon_per_kg' => 5.5]
        );

        $cat = Category::updateOrCreate(
            ['slug' => 't-shirts'],
            ['name' => 'T-Shirts', 'impact_label' => 'Standard Fit']
        );

        $product = Product::updateOrCreate(
            ['slug' => 'earth-first-tee'],
            [
                'category_id' => $cat->id,
                'name' => 'Earth First Tee',
                'description' => 'A super soft organic cotton tee designed for maximum longevity and minimum footprint.',
                'price_cents' => 4500,
                'material_composition' => [['material' => 'Organic Cotton', 'percent' => 100]],
                'is_published' => true,
                'sustainability_score' => 10,
            ]
        );

        ProductVariant::updateOrCreate(
            ['product_id' => $product->id, 'size' => 'M', 'color' => 'Sage'],
            ['physical_weight_kg' => 0.25, 'stock_quantity' => 100]
        );

        ProductVariant::updateOrCreate(
            ['product_id' => $product->id, 'size' => 'L', 'color' => 'Sage'],
            ['physical_weight_kg' => 0.30, 'stock_quantity' => 100]
        );
    }
}
