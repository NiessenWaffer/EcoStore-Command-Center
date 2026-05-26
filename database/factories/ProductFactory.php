<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'price_cents' => rand(1000, 10000),
            'sustainability_score' => rand(1, 10),
            'is_published' => true,
            'image_url' => 'https://example.com/product.jpg',
            'material_composition' => ['Organic Cotton' => 100],
            'materials_cost_cents' => 500,
            'labor_cost_cents' => 1000,
            'shipping_cost_cents' => 500,
            'operations_cost_cents' => 500,
        ];
    }
}
