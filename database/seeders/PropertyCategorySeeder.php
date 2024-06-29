<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Rent\PropertyCategory;

class PropertyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyCategory::firstOrCreate(
            ['code' => 'PlZ'],
            ['name' => 'Plaza',
                'description' => 'Plaza',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PropertyCategory::firstOrCreate(
            ['code' => 'MAL'],
            ['name' => 'Mall',
                'description' => 'Mall',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

    }
}
