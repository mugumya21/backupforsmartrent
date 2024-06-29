<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Rent\UnitType;

class UnitypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitType::firstOrCreate(
            ['code' => 'SINGLE'],
            ['name' => 'Single',
                'description' => 'Single',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        UnitType::firstOrCreate(
            ['code' => 'DOUBLE'],
            ['name' => 'Double',
                'description' => 'Double',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

    }
}
