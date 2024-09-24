<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesPermissionsTableSeeder::class);
        $this->call(UserStatusesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PaymentOptionsTableSeeder::class);
        $this->call(ClinicsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(SpeciesTableSeeder::class);
        $this->call(PetsTableSeeder::class);
        $this->call(ClinicServicesTableSeeder::class);
        $this->call(ClinicServicePricesTableSeeder::class);
    }
}
