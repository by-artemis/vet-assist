<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\ClinicService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = Clinic::whereNull('deleted_at')->get();

        foreach ($clinics as $clinic) {
            ClinicService::factory()->create([
                'clinic_id' => $clinic->id,
            ]);
        }
    }
}
