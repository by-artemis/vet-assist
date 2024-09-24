<?php

namespace Database\Seeders;

use App\Models\PaymentOption;
use Illuminate\Database\Seeder;

class PaymentOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentOptions = [
            ['name' => 'Cash'],
            ['name' => 'GCash'],
            ['name' => 'Credit Card'],
            ['name' => 'Debit Card'],
            ['name' => 'Maya'],
        ];

        foreach ($paymentOptions as $option) {
            PaymentOption::create($option);
        }
    }
}
