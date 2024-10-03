<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetVaccine>
 */
class PetVaccineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vaccines = ['FVRCP', 'Rabies', 'Bordetella', 'Leptospirosis', 'Parvo', 'Distemper'];

        return [
            'vaccine' => fake()->randomElement($vaccines),
            'last_vaccinated_at' => fake()->dateTimeBetween('-2 years', '-1 month'), // Vaccinated within the last 2 years
        ];
    }
}
