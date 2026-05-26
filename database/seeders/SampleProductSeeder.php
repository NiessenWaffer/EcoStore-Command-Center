<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SustainabilityMetric;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleProductSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Metrics
        $metrics = [
            ['material_type' => 'Organic Cotton', 'water_per_kg' => 2000, 'carbon_per_kg' => 5.5],
            ['material_type' => 'Recycled Polyester', 'water_per_kg' => 500, 'carbon_per_kg' => 3.2],
            ['material_type' => 'Tencel Lyocell', 'water_per_kg' => 1200, 'carbon_per_kg' => 2.8],
            ['material_type' => 'Hemp', 'water_per_kg' => 300, 'carbon_per_kg' => 1.5],
            ['material_type' => 'Recycled Wool', 'water_per_kg' => 800, 'carbon_per_kg' => 4.1],
        ];

        foreach ($metrics as $metric) {
            SustainabilityMetric::updateOrCreate(['material_type' => $metric['material_type']], $metric);
        }

        $categories = [
            [
                'name' => 'Outerwear', 
                'slug' => 'outerwear', 
                'impact_label' => 'Climate Shield', 
                'image_url' => 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Basics', 
                'slug' => 'basics', 
                'impact_label' => 'Daily Essential', 
                'image_url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Accessories', 
                'slug' => 'accessories', 
                'impact_label' => 'Eco-Accents', 
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80'
            ],
        ];

        $productImages = [
            'outerwear' => [
                'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1545591302-d5f617465ed3?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?auto=format&fit=crop&w=1200&q=80',
            ],
            'basics' => [
                'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1576566582415-885496464521?auto=format&fit=crop&w=1200&q=80',
            ],
            'accessories' => [
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=1200&q=80',
            ]
        ];

        foreach ($categories as $catData) {
            $category = Category::updateOrCreate(['slug' => $catData['slug']], $catData);

            for ($i = 1; $i <= 6; $i++) {
                $name = $catData['name'] . " " . ($i % 2 == 0 ? "Signature" : "Essential") . " " . $i;
                $slug = Str::slug($name);

                $products = [
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => $slug,
                    'description' => "A high-fidelity sustainable " . strtolower($catData['name']) . " piece, built for durability and minimal footprint.",
                    'price_cents' => rand(3500, 25000),
                    'sustainability_score' => rand(60, 100) / 10,
                    'is_published' => true,
                    'image_url' => $productImages[$catData['slug']][($i - 1) % 4],
                    'material_composition' => [
                        'Organic Cotton' => rand(50, 100),
                        'Hemp' => rand(0, 30),
                        'Recycled Polyester' => rand(0, 20),
                    ],
                    'materials_cost_cents' => rand(500, 2000),
                    'labor_cost_cents' => rand(800, 2500),
                    'shipping_cost_cents' => 500,
                    'operations_cost_cents' => 1000,
                ];

                $product = Product::updateOrCreate(['slug' => $slug], $products);

                // Add variants
                foreach (['S', 'M', 'L', 'XL'] as $size) {
                    foreach (['Stone', 'Olive', 'Charcoal', 'Bone'] as $color) {
                        ProductVariant::firstOrCreate([
                            'product_id' => $product->id,
                            'size' => $size,
                            'color' => $color,
                        ], [
                            'stock_quantity' => rand(5, 100),
                            'physical_weight_kg' => 0.45,
                        ]);
                    }
                }
            }
        }
    }
}
