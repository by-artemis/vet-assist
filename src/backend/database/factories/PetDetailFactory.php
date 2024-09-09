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

        return [
            'coat' => fake()->randomElement($coats),
            'pattern' => fake()->randomElement($patterns),
            'weight' => fake()->randomFloat(2, 1, 50), // Random weight between 1 and 50 kg
            'last_weighed_at' => fake()->dateTimeBetween('-1 year'),
            'is_disabled' => fake()->boolean(1), // 1% chance of being disabled
        ];
    }
}
