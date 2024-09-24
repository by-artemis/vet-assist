<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;

class SpeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $species = [
            ['name' => 'Cat'],
            ['name' => 'Dog'],
            ['name' => 'Rabbit'],
            ['name' => 'Hamster'],
            ['name' => 'Guinea Pig'],
            ['name' => 'Bird'],
            ['name' => 'Fish'],
            ['name' => 'Spider'],
        ];

        foreach ($species as $specie) {
            Species::create($specie);
        }
    }
}
