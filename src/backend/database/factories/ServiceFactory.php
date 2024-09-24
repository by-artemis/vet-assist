<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Wellness Exam',
                'Vaccination',
                'Dental Cleaning',
                'Surgery',
                'X-ray',
                'Ultrasound',
                'Blood Test',
                'Grooming',
                'Boarding',
                'Microchipping',
                'Behavioral Consultation',
                'Nutritional Counseling',
            ]),
        ];
    }
}
