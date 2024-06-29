<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Main\DocumentStatus;

class DocumentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentStatus::firstOrCreate(
            ['code' => 'TEMP'],
            ['name' => 'Temporary file',
                'description' => 'Temporary file',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentStatus::firstOrCreate(
            ['code' => 'SAVED'],
            ['name' => 'Processed and saved',
                'description' => 'Processed and saved',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentStatus::firstOrCreate(
            ['code' => 'FEATURED'],
            ['name' => 'Featured Image',
                'description' => 'Featured Image',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        
        DocumentStatus::firstOrCreate(
            ['code' => 'CLIENTLOGO'],
            ['name' => 'Client  Logo',
                'description' => '',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );


    }
}
