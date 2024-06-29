<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Accounts\InvoiceStatus;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        InvoiceStatus::firstOrCreate(
            ['code' => 'ADDED'],
            [
                'name' => 'Created',
                'description' => 'Submitted for approval',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        InvoiceStatus::firstOrCreate(
            ['code' => 'SUBMITTED'],
            [
                'name' => 'Submitted for approval',
                'description' => 'Submitted for approval',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        InvoiceStatus::firstOrCreate(
            ['code' => 'APPROVED'],
            [
                'name' => 'Approved',
                'description' => 'Approved',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        InvoiceStatus::firstOrCreate(
            ['code' => 'REJECTED'],
            [
                'name' => 'Rejected',
                'description' => 'Rejected',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        InvoiceStatus::firstOrCreate(
            ['code' => 'RETURNED'],
            [
                'name' => 'Rejected',
                'description' => 'Rejected',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        InvoiceStatus::firstOrCreate(
            ['code' => 'EDITED'],
            [
                'name' => 'Edited',
                'description' => 'EDITED',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );


    }
}
