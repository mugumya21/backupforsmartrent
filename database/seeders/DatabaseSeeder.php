<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesSeeder::class,
            AdminUserSeeder::class,
            BranchSeeder::class,
            AdminEmployeedetailsSeeder::class,
            NationsSeeder::class,
            MaritalStatusSeeder::class,
            ClientTypeSeeder::class,
            ContactTypeSeeder::class,
            DocumentTypeSeeder::class,
            PropertyCategorySeeder::class,
            PropertyTypeSeeder::class,
            DocumentStatusSeeder::class,
            CurrencySeeder::class,
            PeriodSeeder::class,
            UnitypeSeeder::class,
            paymentmodeSeeder::class,
            AccountsSeeder::class,
            ExpenseCategorySeeder::class,
            BaseCurrencySeeder::class,
            SubscriberLimitSeeder::class,
            PermissionsSeeder::class,
            InvoiceTypeSeeder::class,
            TaxesSeeder::class,
            InvoiceStatusSeeder::class,
            ExpenseStatusSeeder::class,
            MonthsSeeder::class

        ]);

    }
}