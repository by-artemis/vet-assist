<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Clinic;
use App\Models\PetDetail;
use App\Models\PetVaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $species = ['cat', 'dog', 'rabbit', 'hamster', 'guinea pig', 'bird', 'fish'];
        $breeds = [
            'cat' => ['Local Puspin', 'Siamese', 'Persian', 'Maine Coon', 'British Shorthair'],
            'dog' => ['Labrador Retriever', 'German Shepherd', 'Golden Retriever', 'Poodle'],
            'rabbit' => ['Dutch', 'Lionhead', 'Harlequin', 'Mini Rex'],
            'hamster' => ['Syrian', 'Dwarf Campbell', 'Dwarf Winter White', 'Roborovski'],
            'guinea pig' => ['American', 'Abyssinian', 'Peruvian', 'Texel'],
            'bird' => ['Budgerigar', 'Cockatiel', 'Canary', 'Lovebird'],
            'fish' => ['Goldfish', 'Betta', 'Guppy', 'Tetra'],
        ];

        $selectedSpecies = fake()->randomElement($species);

        
        return [
            'name' => fake()->firstName(),
            'birthdate' => fake()->dateTimeBetween('-10 years', '-1 year'),
            'gender' => fake()->randomElement(['male', 'female']),
            'species' => $selectedSpecies,
            'breed' => fake()->randomElement($breeds[$selectedSpecies]),
            'is_microchipped' => fake()->boolean(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Pet $pet) {
            $pet->details()->save(PetDetail::factory()->make());
            
            $clinicIds = Clinic::pluck('id')->toArray(); 

            $pet->vaccines()->saveMany(PetVaccine::factory()
                ->count(rand(1, 3)) // Randomly 1 to 3 vaccinations per pet
                ->state(function (array $attributes) use ($clinicIds, $pet) {
                    return [
                        'pet_id' => $pet->id, // Link to the current pet
                        'clinic_id' => $this->faker->randomElement($clinicIds), // Link to a random clinic
                    ];
                })
                ->make());
        });
    }
}
