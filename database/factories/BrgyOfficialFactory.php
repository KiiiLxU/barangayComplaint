<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrgyOfficial>
 */
class BrgyOfficialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement(['Captain', 'Kagawad', 'Secretary', 'Treasurer', 'Tanod']),
            'photo' => null,
            'contact_no' => $this->faker->phoneNumber(),
            'purok_assigned' => $this->faker->numberBetween(1, 10),
        ];
    }
}
