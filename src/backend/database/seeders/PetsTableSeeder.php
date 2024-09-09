<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class PetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '!=', 1)->get(); // Exclude admin user

        foreach ($users as $user) {
            $numPets = rand(0, 3);

            Pet::factory()
                ->count($numPets)
                ->state(function (array $attributes) use ($user) {
                    return ['owner_id' => $user->id];
                })
                ->create();
        }
    }
}
