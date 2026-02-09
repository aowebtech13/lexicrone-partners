<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\InvestmentPlan::create([
            'name' => 'Starter Plan',
            'description' => 'Perfect for beginners starting their forex journey.',
            'min_amount' => 100,
            'max_amount' => 1000,
            'interest_rate' => 1.5,
            'duration_days' => 30,
            'return_type' => 'daily',
        ]);

        \App\Models\InvestmentPlan::create([
            'name' => 'Advance Plan',
            'description' => 'For serious investors looking for higher returns.',
            'min_amount' => 1001,
            'max_amount' => 5000,
            'interest_rate' => 2.5,
            'duration_days' => 60,
            'return_type' => 'daily',
        ]);

        \App\Models\InvestmentPlan::create([
            'name' => 'Premium Plan',
            'description' => 'Maximum returns for our most dedicated partners.',
            'min_amount' => 5001,
            'max_amount' => 50000,
            'interest_rate' => 4.0,
            'duration_days' => 90,
            'return_type' => 'daily',
        ]);
    }
}
