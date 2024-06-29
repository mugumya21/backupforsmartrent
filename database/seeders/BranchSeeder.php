<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Branch;
use App\Models\User;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemUser = User::where('email', 'system@smartcase.co.ug')->firstOrFail();
        Branch::firstOrCreate(
            ['code' => 'MAIN'],
            [
                'name' => 'Main',
                'description' => 'Main',
                'created_by' => $systemUser->id,
                'created_at' => Carbon::now()]
        );

    }
}
