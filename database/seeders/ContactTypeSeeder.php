<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Main\ContactType;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactType::firstOrCreate(
            ['code' => 'EMAIL'],
            [
                'name' => 'Email',
                'description' => 'Email',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ContactType::firstOrCreate(
            ['code' => 'TELEPHONE'],
            [
                'name' => 'Telephone',
                'description' => 'Telephone',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ContactType::firstOrCreate(
            ['code' => 'MOBILE'],
            [
                'name' => 'Mobile Phone',
                'description' => 'Mobile Phone',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );

        ContactType::firstOrCreate(
            ['code' => 'FAX'],
            [
                'name' => 'Fax',
                'description' => 'Fax',
                'created_by' => 1,
                'created_at' => Carbon::now()]
        );
    }
}
