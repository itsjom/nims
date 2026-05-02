<?php

namespace Database\Factories;

use App\Models\ClinicalInstructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClinicalInstructor>
 */
class ClinicalInstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'name' => $name,
            // 'instructor_contact' => fake()->phoneNumber(),
            // 'instructor_email' => fake()->email(),
        ];
    }
}
