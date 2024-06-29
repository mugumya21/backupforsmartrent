<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accounts\PaymentMode;
use Carbon\Carbon;

class paymentmodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMode::firstOrCreate(
            ['code' => 'CASH'],
            [
                'name' => 'Cash',
                'description' => 'Cash',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PaymentMode::firstOrCreate(
            ['code' => 'CHEQUE'],
            [
                'name' => 'Cheque',
                'description' => 'Cheque',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PaymentMode::firstOrCreate(
            ['code' => 'MTN'],
            [
                'name' => 'MTN Mobile money',
                'description' => 'MTN Mobile money',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PaymentMode::firstOrCreate(
            ['code' => 'AIRTEL'],
            [
                'name' => 'Airtel money',
                'description' => 'Airtel money',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PaymentMode::firstOrCreate(
            ['code' => 'RTGS'],
            [
                'name' => 'Real-time Gross Settlement ',
                'description' => 'Real-time Gross Settlement ',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

        PaymentMode::firstOrCreate(
            ['code' => 'EFT'],
            [
                'name' => 'Electronic funds transfer',
                'description' => 'Electronic funds transfer',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
    }
}
