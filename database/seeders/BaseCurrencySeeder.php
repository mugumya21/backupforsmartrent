<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\System\Setting;
use App\Models\User;
use Carbon\Carbon;

class BaseCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemUser = User::where('email', 'system@smartcase.co.ug')->firstOrFail();
        $basecurrency = Setting::where('key', 'Base_Currency')->first();
        if(empty($basecurrency)){
            Setting::firstOrCreate(
                ['key' => 'Base_Currency'],
                [
                    'value' => 'UGX',
                    'description' => '',
                    'created_by' => $systemUser->id,
                    'created_at' => Carbon::now()]
            );
        }
        
    }
}
