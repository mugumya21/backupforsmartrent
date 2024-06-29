<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Rent\PropertyType;


class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyType::firstOrCreate(
            ['code' => 'COM'],
            ['name' => 'Commercial',
                'description' => 'Commercial',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PropertyType::firstOrCreate(
            ['code' => 'RES'],
            ['name' => 'Residential',
                'description' => 'Residential',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PropertyType::firstOrCreate(
            ['code' => 'RC'],
            ['name' => 'Residential & Commercial',
                'description' => 'Residential & Commercial',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

    }
}
