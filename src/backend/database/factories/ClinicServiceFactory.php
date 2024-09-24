<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClinicService>
 */
class ClinicServiceFactory extends Factory
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
            'is_active' => fake()->boolean(),
        ];
    }

    /**
     * Configure the factory to ensure each clinic has at least one service.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (ClinicService $clinicService) {
            // Get all service IDs
            $serviceIds = Service::pluck('id')->toArray();

            // Generate a random number of additional services (0 to 4)
            $additionalServicesCount = fake()->numberBetween(0, 4);

            // Create additional clinic services for the same clinic
            for ($i = 0; $i < $additionalServicesCount; $i++) {
                ClinicService::create([
                    'clinic_id' => $clinicService->clinic_id,
                    'service_id' => fake()->randomElement($serviceIds),
                    'is_active' => fake()->boolean(),
                ]);
            }
        });
    }
}
