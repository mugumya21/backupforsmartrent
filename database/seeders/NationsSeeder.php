<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Main\Nation;
use Carbon\Carbon;

class NationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nation::firstOrCreate(['code' => 'UG'],
        ['name' => 'Uganda',
            'created_by' => 1,
            'created_at' => Carbon::now()]
    );

    Nation::firstOrCreate(['code' => 'KE'],
        ['name' => 'Kenya',
            'created_by' => 1,
            'created_at' => Carbon::now()]
    );

    Nation::firstOrCreate(['code' => 'TZ'],
        ['name' => 'Tanzania',
            'created_by' => 1,
            'created_at' => Carbon::now()]
    );
}
    
}
