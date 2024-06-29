<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Accounts\InvoiceType;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceType::firstOrCreate(['code' => 'INV'],
            ['name' => 'Invoice',
                'created_by' => 1,'created_at' => Carbon::now()]
        );
        InvoiceType::firstOrCreate(['code' => 'TN'],
            ['name' => 'Tax Invoice',
                'created_by' => 1,'created_at' => Carbon::now()]
        );
        InvoiceType::firstOrCreate(['code' => 'FN'],
            ['name' => 'Fee Note',
                'created_by' => 1,'created_at' => Carbon::now()]
        );
        InvoiceType::firstOrCreate(['code' => 'PN'],
            ['name' => 'Proforma Invoice',
                'created_by' => 1,'created_at' => Carbon::now()]
        );
    }
}
