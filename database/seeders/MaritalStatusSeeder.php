<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HR\MaritalStatus;
use Carbon\Carbon;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        MaritalStatus::firstOrCreate(['code' => 'Single'],
                [
                    'name' => 'Single',
                    'description' => 'Single',
                    'created_by' => 1,
                    'created_at' => Carbon::now()
                ]
            );
    
            MaritalStatus::firstOrCreate(['code' => 'Married'],
                [
                    'name' => 'Married',
                    'description' => 'Married',
                    'created_by' => 1,
                    'created_at' => Carbon::now()
                ]
            );
    
            MaritalStatus::firstOrCreate(['code' => 'Divorced'],
                [
                    'name' => 'Divorced',
                    'description' => 'Divorced',
                    'created_by' => 1,
                    'created_at' => Carbon::now()
                ]
            );
        }
}
