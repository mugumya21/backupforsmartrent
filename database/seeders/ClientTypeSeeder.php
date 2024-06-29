<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CRM\ClientType;
use App\Models\User;
use Carbon\Carbon;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemUser = User::where('email', 'system@smartcase.co.ug')->firstOrFail();
        ClientType::firstOrCreate(
            ['code' => 'IND'],
            [
                'name' => 'Individual',
                'description' => 'Individual',
                'created_by' => $systemUser->id,
                'created_at' => Carbon::now()]
        );

        ClientType::firstOrCreate(
            ['code' => 'COM'],
            [
                'name' => 'Company',
                'description' => 'Company',
                'created_by' => $systemUser->id,
                'created_at' => Carbon::now()]
        );
    }
}
