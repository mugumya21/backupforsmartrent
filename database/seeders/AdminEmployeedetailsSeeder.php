<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin\Branch;
use App\Models\HR\Employee;
use Carbon\Carbon;

class AdminEmployeedetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::where('code', 'Main')->firstOrFail();
        $systemUser = User::where('email', 'system@smartcase.co.ug')->firstOrFail();


    Employee::firstOrCreate(['user_id' => $systemUser->id],
        [
            'first_name' => 'System',
            'middle_name' => '',
            'last_name' => 'System',
            'telephone' => '00000000',
            'date_of_birth' => Carbon::create(1986, 1, 31, 0),
            'gender' => 1,
            'branch_id' => $branch->id,
            'user_id' => $systemUser->id,
            'created_by' => $systemUser->id,
            'created_at' => Carbon::now()
        ]);

        $adminUser = User::where('email', 'admin@example.com')->firstOrFail();

    Employee::firstOrCreate(['user_id' => $adminUser->id],
        [
        'first_name' => 'John',
        'middle_name' => '',
        'last_name' => 'Doe',
        'telephone' => '09875678',
        'date_of_birth' => Carbon::create(1986, 1, 31, 0),
        'gender' => 1,
        'branch_id' => $branch->id,
        'user_id' => $adminUser->id,
        'created_by' => $adminUser->id,
        'created_at' => Carbon::now()
    ]);
    }
    
}
