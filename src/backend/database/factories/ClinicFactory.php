<?php

namespace Database\Factories;

use App\Models\PaymentOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $suffixes = [
            'Veterinary Clinic',
            'Clinic',
            'Veterinary Services',
            'Animal Clinic',
            'Animal Hospital',
            'Pet Hospital',
            'Veterinary Center',
            'Pet Care Center',
            'Animal Medical Center'
        ];

        // Define possible office hour patterns
        $officeHourPatterns = [
            'Mon-Fri: 9AM-5PM, Sat: 9AM-12PM' => false,
            'Mon-Sat: 8AM-6PM' => false,
            'Mon-Fri: 10AM-7PM' => false,
            'Tues-Sun: 9AM-4PM' => false,
            'Everyday: 9AM-5PM' => false,
            '24/7' => true // Add 24/7 with is_24_7 = true
        ];
        $officeHours = fake()->randomElement(array_keys($officeHourPatterns));
        $is247 = $officeHourPatterns[$officeHours];

        // Get all payment option IDs
        $paymentOptionIds = PaymentOption::pluck('id')->toArray();

        return [
            'name' => fake()->company() . ' ' . fake()->randomElement($suffixes),
            'address' => fake()->streetAddress(),
            'office_hours' => $officeHours,
            'is_24_7' => $is247,
            'phone_number' => fake()->phoneNumber(),
            'logo' => fake()->optional()->imageUrl(),
            'photos' => collect(range(1, 3)) // Generate 3 photo URLs
                ->map(fn() => 'https://picsum.photos/640/480')
                ->implode(','),
            'payment_option_ids' =>  implode(',', fake()->randomElements(
                $paymentOptionIds, fake()->numberBetween(1, count($paymentOptionIds))
            )), 
            'email' => fake()->safeEmail(),
            'website' => 'https://' . fake()->optional()->domainName(),
            'description' => fake()->paragraph(2),
        ];
    }
}
