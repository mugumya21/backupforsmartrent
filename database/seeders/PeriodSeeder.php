<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Rent\Period;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Period::firstOrCreate(
            ['code' => 'DAILY'],
            ['name' => 'Daily',
                'description' => 'Daily',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Period::firstOrCreate(
            ['code' => 'WEEKLY'],
            ['name' => 'Weekly',
                'description' => 'Weekly',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Period::firstOrCreate(
            ['code' => 'MONTHLY'],
            ['name' => 'Monthly',
                'description' => 'Monthly',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Period::firstOrCreate(
            ['code' => 'YEARLY'],
            ['name' => 'Yearly',
                'description' => 'Yearly',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );


    }
}
