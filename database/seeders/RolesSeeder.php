<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'property_manager'],
        ['guard_name' => 'web', 'description' => 'property_manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );

    Role::firstOrCreate(['name' => 'landlord'],
        ['guard_name' => 'web', 'description' => 'landlord',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );

    Role::firstOrCreate(['name' => 'supervisor'],
        ['guard_name' => 'web', 'description' => 'supervisor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );


    Role::firstOrCreate(['name' => 'cashier'],
        ['guard_name' => 'web', 'description' => 'cashier',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );


   

    }
}







