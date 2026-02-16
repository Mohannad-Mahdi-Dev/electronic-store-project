<?php

namespace Database\Factories;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $price = $this->faker->randomFloat(2, 10, 500);

        return [
            'name' => $this->faker->randomElement(['iPhone 15 Pro', 'Galaxy S24 Ultra', 'MacBook Air M3', 'Sony WH-1000XM5', 'Apple Watch Series 9']),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['name']) . '-' . rand(100, 999);
            },
            'description' => 'High-performance electronic device with the latest technology features and official warranty.',
            'sku' => 'ELEC-' . strtoupper(Str::random(10)),
            'price' => $this->faker->randomFloat(2, 100, 2000),
            'compare_price' => $this->faker->randomFloat(2, 2100, 2500),
            'stock' => $this->faker->numberBetween(5, 50),
            'image' => 'admin-assets/img/products/default-electronic.jpg',
            'is_active' => true,
            'is_featured' => $this->faker->boolean(20),
            'status' => 1,
        ];
    }
}
