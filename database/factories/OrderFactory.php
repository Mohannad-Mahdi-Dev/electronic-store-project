<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 50, 500);
        $discount = $this->faker->randomElement([0, 10, 20]);
        $shipping = 10.00;

        return [
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'shipping_fee' => $shipping,
            'total' => ($subtotal - $discount) + $shipping,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'shipped', 'delivered', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['cod', 'card', 'wallet']),
            'payment_status' => $this->faker->randomElement(['paid', 'unpaid']),
            'shipping_name' => $this->faker->name(),
            'shipping_phone' => '7' . $this->faker->numberBetween(700000000, 789999999),
            'shipping_address' => $this->faker->address(),
            'shipping_city' => $this->faker->randomElement(['Sana\'a', 'Aden', 'Taiz', 'Ibb']),
            'shipping_notes' => $this->faker->sentence(),
        ];
    }
}
