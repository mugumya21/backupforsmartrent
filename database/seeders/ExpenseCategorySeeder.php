<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Rent\ExpenseCategory;


class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseCategory::firstOrCreate(
            ['code' => 'WTBILL'],
            [
                'name' => 'Water Bill',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ExpenseCategory::firstOrCreate(
            ['code' => 'ELEC'],
            [
                'name' => 'Electricity',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );
        ExpenseCategory::firstOrCreate(
            ['code' => 'PLUM'],
            [
                'name' => 'Plumbing',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ExpenseCategory::firstOrCreate(
            ['code' => 'CVW'],
            [
                'name' => 'Civil Works',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ExpenseCategory::firstOrCreate(
            ['code' => 'PAINT'],
            [
                'name' => 'Painting',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ExpenseCategory::firstOrCreate(
            ['code' => 'SAL'],
            [
                'name' => 'Salary',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ExpenseCategory::firstOrCreate(
            ['code' => 'TRS'],
            [
                'name' => 'Transport',
                'description' => '',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

    }
}
