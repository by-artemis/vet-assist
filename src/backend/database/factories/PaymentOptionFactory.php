<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentOption>
 */
class PaymentOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentOptions = [
            'Cash',
            'GCash',
            'Credit Card',
            'Debit Card',
            'Maya',
        ];

        return [
            'name' => fake()->randomElement($paymentOptions)
        ];
    }
}
