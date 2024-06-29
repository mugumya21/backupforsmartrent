<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Services\Admin\iRoleService;
use App\Models\User;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $roleService;

     public function __construct(iRoleService $roleService)
     {
         $this->roleService = $roleService;
     }

    public function index()
    {
        $roles = Role::all();

        if (request()->ajax()) {

            return view('admin.roles.roles_table', ['roles' => $roles]);

        } else {
            return view('admin.roles.index', ['roles' => $roles]);
        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = new Role();
        return view('admin.roles.create-modal', ['role' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $role = $this->roleService->create($request);

            return response()->json(
                [
                    'message' => 'Action was successfull',
                    'url' => route('admin.roles.index'),
                    'target' => '#roles-loader'
                ], 200);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'text' => ''
                ], 400);
        }
    }



    public function assignpermissionSubmit(Request $request)
    {
        try {
                     
            $role = $this->roleService->assignpermissionSubmit($request);
            return response()->json(
                [
                    'message' => 'Action was successfull',
                    'url' => route('admin.roles.show',$role),
                    'target' => '#permissions-loader'
                ], 200);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'text' => ''
                ], 400);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->roleService->get($id);
        $users = User::role($role->name)->get();
        return view('admin.roles.show', ['role' => $role,'users'=>$users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findorfail($id);
        return view('admin.roles.edit-modal', ['role' => $role]);
    }

    public function assignpermissions(string $id)
    {
        $role = Role::findorfail($id);
        $permissions = Permission::all();
        $rolepermissions =  $role->permissions;
        return view('admin.roles.assign-permissions-modal', ['role' => $role, 'permissions'=>$permissions,'rolepermissions'=>$rolepermissions]);
    }


    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $role = $this->roleService->update($request,$id);

            return response()->json(
                [
                    'message' => 'Action was successfull',
                    'url' => route('admin.roles.index'),
                    'target' => '#roles-loader'
                ], 200);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'text' => ''
                ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
