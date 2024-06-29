<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Accounts\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::firstOrCreate(
            ['code' => 'UGX'],
            [
                'name' => 'Uganda Shillings',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Currency::firstOrCreate(
            ['code' => 'USD'],
            [
                'name' => 'United States Dollars',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Currency::firstOrCreate(
            ['code' => 'GBP'],
            [
                'name' => 'British Pounds',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
       
        Currency::firstOrCreate(
            ['code' => 'EUR'],
            [
                'name' => 'EURO',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        Currency::firstOrCreate(
            ['code' => 'KES'],
            [
                'name' => 'Kenya Shillings',
                'created_by' => 1, 'created_at' => Carbon::now()]
            );
             Currency::firstOrCreate(
            ['code' => 'BIF'],
            [
                'name' => 'Burundian Franc',
                'created_by' => 1, 'created_at' => Carbon::now()]
            );
            Currency::firstOrCreate(
                ['code' => 'TZS'],
                [
                    'name' => 'Tanzanian Shillings',
                    'created_by' => 1, 'created_at' => Carbon::now()]
                );
                Currency::firstOrCreate(
                    ['code' => 'SSP'],
                    [
                        'name' => 'Sudanese Pound',
                        'created_by' => 1, 'created_at' => Carbon::now()]
                    );
    }
}
