<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinicIds = Clinic::pluck('id')->toArray(); 

        Doctor::factory(10)->create([
            'clinic_id' => function () use ($clinicIds) {
                return fake()->randomElement($clinicIds);
            }
        ]);
    }
}
