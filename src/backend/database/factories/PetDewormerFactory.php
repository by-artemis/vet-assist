<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetVaccine>
 */
class PetDewormerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dewormers = ['Pyrantel Pamoate', 'Fenbendazole', 'Praziquantel', 'Milbemycin Oxime'];

        return [
            'dewormer' => fake()->randomElement($dewormers),
            'last_dewormed_at' => fake()->dateTimeBetween('-1 year', '-1 month'), // Dewormed within the last year
        ];
    }
}
