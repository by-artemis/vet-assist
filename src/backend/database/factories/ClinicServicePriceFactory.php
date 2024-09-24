<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\ClinicServicePrice;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClinicServicePrice>
 */
class ClinicServicePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get all clinic IDs and service IDs
        $clinicIds = Clinic::pluck('id')->toArray();
        $serviceIds = Service::pluck('id')->toArray();

        return [
            'clinic_id' => fake()->randomElement($clinicIds),
            'service_id' => fake()->randomElement($serviceIds),
            'price' => fake()->randomFloat(2, 50, 5000), // Adjust price range as needed
        ];
    }

    /**
     * Configure the factory to ensure unique service_id per clinic
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (ClinicServicePrice $clinicServicePrice) {
            // Get all service IDs except the one already associated with this clinic
            $otherServiceIds = Service::where('id', '!=', $clinicServicePrice->service_id)
                ->pluck('id')
                ->toArray();

            // Generate a random number of additional service prices (0 to 3)
            $additionalPricesCount = fake()->numberBetween(0, 3);

            // Create additional clinic service prices for the same clinic, but with different services
            for ($i = 0; $i < $additionalPricesCount; $i++) {
                ClinicServicePrice::create([
                    'clinic_id' => $clinicServicePrice->clinic_id,
                    'service_id' => fake()->randomElement($otherServiceIds),
                    'price' => fake()->randomFloat(2, 50, 5000),
                ]);
            }
        });
    }
}
