<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\Owner;
use Illuminate\Database\Seeder;

class PetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = Owner::whereNull('deleted_at')
            ->whereNot('user_id', 1) // Exclude admin
            ->get();

        foreach ($owners as $owner) {
            $numPets = rand(0, 3);

            Pet::factory()
                ->count($numPets)
                ->state(function (array $attributes) use ($owner) {
                    return ['owner_id' => $owner->id];
                })
                ->create();
        }
    }
}
