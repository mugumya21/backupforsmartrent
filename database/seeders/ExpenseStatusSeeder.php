<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rent\ExpenseStatus;
use Carbon\Carbon;

class ExpenseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseStatus::firstOrCreate(
            ['code' => 'ADDED'],
            [
                'name' => 'Created',
                'description' => 'Submitted for approval',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        ExpenseStatus::firstOrCreate(
            ['code' => 'SUBMITTED'],
            [
                'name' => 'Submitted for approval',
                'description' => 'Submitted for approval',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        ExpenseStatus::firstOrCreate(
            ['code' => 'APPROVED'],
            [
                'name' => 'Approved',
                'description' => 'Approved',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        ExpenseStatus::firstOrCreate(
            ['code' => 'REJECTED'],
            [
                'name' => 'Rejected',
                'description' => 'Rejected',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        ExpenseStatus::firstOrCreate(
            ['code' => 'RETURNED'],
            [
                'name' => 'Rejected',
                'description' => 'Rejected',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );
        ExpenseStatus::firstOrCreate(
            ['code' => 'EDITED'],
            [
                'name' => 'Edited',
                'description' => 'EDITED',
                'created_by' => 1, 'created_at' => Carbon::now()]
        );

    }
}
