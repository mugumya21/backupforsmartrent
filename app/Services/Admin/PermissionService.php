<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\HR\RoleHasPermissions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;


class PermissionService implements iPermissionService
{
    

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $permission = new Permission();
            $permission->name = $request->name;
            $permission->guard_name = 'web';
            $permission->save();

            DB::commit();
            return $permission;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $permission = Permission::findorfail($id);
            $permission->name = $request->name;
            $permission->save();

            DB::commit();
            return $permission;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }



}