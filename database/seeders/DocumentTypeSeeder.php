<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Main\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentType::firstOrCreate(
            ['code' => 'EMP'],
            ['name' => 'Employee Documents',
                'description' => 'Employee Documents',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'TND'],
            ['name' => 'Tenant Documents',
                'description' => 'Tenant Documents',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'TUND'],
            ['name' => 'Tenant Unit Documents',
                'description' => 'Tenant Units Documents',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'PTD'],
            ['name' => 'Property Documents',
                'description' => 'Property Documents',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'UND'],
            ['name' => 'Unit Documents',
                'description' => 'Unit Documents',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'TUNDGAL'],
            ['name' => 'Tenant Unit Gallery',
                'description' => 'Tenant Units Gallery',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'PTDGAL'],
            ['name' => 'Property Gallery',
                'description' => 'Property Gallery',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'EXPENSES'],
            ['name' => 'Expenses',
                'description' => 'Expenses',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'PAYMENTS'],
            ['name' => 'Payments',
                'description' => 'Payment Documents',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        DocumentType::firstOrCreate(
            ['code' => 'CLIENTLOGO'],
            ['name' => 'CLIENTLOGO',
                'description' => '',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );


    }
}
