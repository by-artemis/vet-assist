<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'is_licensed' => fake()->boolean(90),
            'specialty' => fake()->randomElement([
                'General Practice/Primary Care',
                'Feline Medicine',
                'Canine Medicine',
                'Small Animal Medicine',
                'Large Animal Medicine',
                'Equine Medicine',
                'Exotic Animal Medicine',
                'Anesthesiology',
                'Cardiology',
                'Surgery',
                'Dentistry',
                'Internal Medicine',
                'Ophthalmology',
                'Dermatology', 
                'Behavior',
                'Pathology',
                'Emergency and Critical Care',
            ]), 
            'email' => fake()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}
