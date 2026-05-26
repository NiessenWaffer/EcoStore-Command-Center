<?php

namespace Database\Factories;

use App\Models\Factory as FactoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryFactory extends Factory
{
    protected $model = FactoryModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'location' => $this->faker->address(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'ethical_score' => 9.0,
            'certifications' => ['GOTS'],
        ];
    }
}
