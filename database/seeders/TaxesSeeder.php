<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accounts\Tax;
use Carbon\Carbon;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tax::firstOrCreate(['code' => 'N/A'],
        [
            'rate' => '0',
            'name' => 'Non Taxable',
            'code' => 'NIL',
            'created_by' => 1,
            'created_at' => Carbon::now()
        ]
    );

    Tax::firstOrCreate(['code' => 'VAT'],
        [
            'rate' => '18',
            'code' => 'VAT',
            'name' => 'VAT 18%',
            'created_by' => 1,
            'created_at' => Carbon::now()]
    );

    Tax::firstOrCreate(['code' => 'VINC'],
        [
            'rate' => '0',
            'code' => 'VINC',
            'name' => 'VAT Inclusive',
            'created_by' => 1,
            'created_at' => Carbon::now()]
    );
    }
}
