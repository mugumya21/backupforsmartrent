<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\HR\RoleHasPermissions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;


class RoleService implements iRoleService
{
    

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $role = new Role();
            $role->name = $request->name;
            $role->description = $request->description;
            $role->guard_name = 'web';
            $role->save();

            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $role = Role::findorfail($id);
            $role->name = $request->name;
            $role->description = $request->description;
            $role->save();

            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    
    public function get(int $id)
    {
        return Role::findOrFail($id);
    }


    public function assignpermissionSubmit(Request $request)
    {

        DB::beginTransaction();
        try {
            $role = Role::findorfail($request->role_id);
            $permissions =  Permission::whereIn('id',$request->permission_ids)->get();
            $permissions =  $permissions->pluck('name');
            $role->syncPermissions($permissions);

            DB::commit();

            return $role;

            } catch (Exception $e) {
                DB::rollback();
                throw $e;
            }

    }



}