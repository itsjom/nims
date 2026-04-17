<?php

namespace Database\Factories;

use App\Models\BorrowLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BorrowLog>
 */
class BorrowLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_borrowed' => $this->faker->date(),
            'student_name' => $this->faker->name(),
            'contact_info' => $this->faker->phoneNumber(),
            'clinical_instructor' => $this->faker->name(),
            'procedure' => $this->faker->word(),
            'equipment' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['Pending', 'Borrowed', 'Returned']),
            'expected_returned_date' => $this->faker->date(),
        ];
    }
}
