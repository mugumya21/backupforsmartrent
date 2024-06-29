<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\System\Setting;
use Carbon\Carbon;

class SubscriberLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::firstOrCreate(
            ['key' => 'SUBSCRIBE_UNITS_VALUE'],
            ['value' => '0',
                'description' => '',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

    }
}
