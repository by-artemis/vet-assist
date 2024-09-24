<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetDetail>
 */
class PetDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coats = ['red', 'orange', 'yellow', 'white', 'black', 'brown', 'gray', 'cream'];
        $patterns = ['calico', 'tortoiseshell', 'tabby', 'plain', 'spotted', 'striped', 'marble'];

        // Generate a random age representation
        $ageOptions = [
            fake()->numberBetween(1, 15), // Number representing years
            fake()->numberBetween(1, 10) . ' yrs and ' . fake()->numberBetween(1, 11) . ' months', 
            fake()->numberBetween(1, 11) . ' months old'
        ];
        $age = fake()->randomElement($ageOptions);

        // Calculate birthdate based on age
        if (is_numeric($age)) { // If age is just a number (years)
            $birthdate = now()->subYears($age); 
        } else if (strpos($age, 'yrs and') !== false) { // If age is in "X yrs and Y months" format
            preg_match('/(\d+) yrs and (\d+) months/', $age, $matches);
            $years = $matches[1];
            $months = $matches[2];
            $birthdate = now()->subYears($years)->subMonths($months);
        } else { // If age is in "X months old" format
            preg_match('/(\d+) months old/', $age, $matches);
            $months = $matches[1];
            $birthdate = now()->subMonths($months);
        }

        return [
            'age' => $age,
            'birthdate' => $birthdate,
            'coat' => fake()->randomElement($coats),
            'pattern' => fake()->randomElement($patterns),
            'weight' => fake()->randomFloat(2, 1, 50), // Random weight between 1 and 50 kg
            'last_weighed_at' => fake()->dateTimeBetween('-1 year'),
            'is_disabled' => fake()->boolean(1), // 1% chance of being disabled
        ];
    }
}
