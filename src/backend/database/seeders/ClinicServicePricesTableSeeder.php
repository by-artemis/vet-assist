<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;
use App\Models\ClinicServicePrice;

class ClinicServicePricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = Clinic::whereNull('deleted_at')->get();

        foreach ($clinics as $clinic) {
            ClinicServicePrice::factory()->create([
                'clinic_id' => $clinic->id,
            ]);
        }
    }
}
