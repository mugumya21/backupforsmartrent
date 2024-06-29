<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Main\Month;

class MonthsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Month::firstOrCreate(
            ['name' => 'January',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'February',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'March',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'April',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'May',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'June',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'July',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'August',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'September',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'October',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'November',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Month::firstOrCreate(
            ['name' => 'December',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

    }
}
