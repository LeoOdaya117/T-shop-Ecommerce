<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition()
    {
        return [
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'color' => $this->faker->randomElement(['Red', 'Blue', 'Green']),
            'price' => $this->faker->randomFloat(2, 100, 500),  // Price between 100 and 500
            'stock' => $this->faker->numberBetween(1, 50),  // Stock between 1 and 50
        ];
    }
}
