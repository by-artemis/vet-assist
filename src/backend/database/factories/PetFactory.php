<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Clinic;
use App\Models\Species;
use App\Models\PetDetail;
use App\Models\PetVaccine;
use App\Models\PetDewormer;
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
        $breeds = [
            'Cat' => ['Local Puspin', 'Siamese', 'Persian', 'Maine Coon', 'British Shorthair', 'Sphynx'],
            'Dog' => ['Labrador Retriever', 'Labrador', 'Chihuahua', 'German Shepherd', 'Golden Retriever', 'Poodle', 'Shih tzu'],
            'Rabbit' => ['Dutch', 'Lionhead', 'Harlequin', 'Mini Rex'],
            'Hamster' => ['Syrian', 'Dwarf Campbell', 'Dwarf Winter White', 'Roborovski'],
            'Guinea Pig' => ['American', 'Abyssinian', 'Peruvian', 'Texel'],
            'Bird' => ['Budgerigar', 'Cockatiel', 'Canary', 'Lovebird', 'Parrot'],
            'Fish' => ['Goldfish', 'Betta', 'Guppy', 'Tetra'],
            'Spider' => ['Tarantula', 'Jumping Spider', 'Wolf Spider', 'Black Widow', 'Brown Recluse'],
        ];
    
        // Get a random species from the database
        $species = Species::inRandomOrder()->first();

        return [
            'name' => fake()->firstName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'species' => $species,
            'breed' => fake()->randomElement($breeds[$species->name]),
            'photo' => fake()->optional()->imageUrl(),
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

            $pet->dewormers()->saveMany(PetDewormer::factory()
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
