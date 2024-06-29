<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignAdminPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $systemAdmin = User::where('email','system@smartcase.co.ug')->first();
        $admin = User::where('email','admin@example.com')->first();

        $permissions = Permission::all();
        $permissions = $permissions->pluck('name');

        $systemAdmin->syncPermissions($permissions);
        $admin->syncPermissions($permissions);


    }
}
