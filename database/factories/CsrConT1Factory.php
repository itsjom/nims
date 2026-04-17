<?php

namespace Database\Factories;

use App\Models\CsrConT1;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CsrConT1>
 */
class CsrConT1Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->words(3, true),
            'unit' => $this->faker->randomElement(['pc', 'box', 'pack']),
            'ideal_stocks' => $this->faker->numberBetween(50, 100),
            'total_stock' => $this->faker->numberBetween(10, 100),
            'supply_on_hand' => $this->faker->numberBetween(0, 50),
            'location' => 'CSR CABINET ' . $this->faker->numberBetween(1, 10) . 'A',
            'item_condition' => $this->faker->randomElement(['Good', 'New', 'Damaged']),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'last_restock_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'image' => null,
        ];
    }
}
