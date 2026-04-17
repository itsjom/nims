<?php

namespace Database\Factories;

use App\Models\CsrNconT1;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CsrNconT1>
 */
class CsrNconT1Factory extends Factory
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
            'unit' => $this->faker->randomElement(['unit', 'set', 'pc']),
            'ideal_stocks' => $this->faker->numberBetween(10, 50),
            'total_stock' => $this->faker->numberBetween(5, 50),
            'supply_on_hand' => $this->faker->numberBetween(0, 30),
            'location' => 'CSR CABINET ' . $this->faker->numberBetween(1, 10) . 'A',
            'item_condition' => $this->faker->randomElement(['Good', 'New', 'Damaged']),
            'image' => null,
        ];
    }
}
