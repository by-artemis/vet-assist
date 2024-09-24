<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'General Consultation'],
            ['name' => 'Wellness Exam'],
            ['name' => 'Vaccination'],
            ['name' => 'Dental Cleaning'],
            ['name' => 'Surgery'],
            ['name' => 'X-ray'],
            ['name' => 'Ultrasound'],
            ['name' => 'Blood Test'],
            ['name' => 'Grooming'],
            ['name' => 'Boarding'],
            ['name' => 'Microchipping'],
            ['name' => 'Behavioral Consultation'],
            ['name' => 'Nutritional Counseling'],
            ['name' => 'Flea and Tick Treatment'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
