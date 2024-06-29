<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Services\Admin\iPermissionService;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $permissionService;

     public function __construct(iPermissionService $permissionService)
     {
         $this->permissionService = $permissionService;
     }


    public function index()
    {
        $permissions = Permission::all();

        if (request()->ajax()) {

            return view('admin.permissions.permissions_table', ['permissions' => $permissions]);

        } else {
            return view('admin.permissions.index', ['permissions' => $permissions]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = new Permission();
        return view('admin.permissions.create-modal', ['permission' => $permission]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $permission = $this->permissionService->create($request);

            return response()->json(
                [
                    'message' => 'Action was successfull',
                    'url' => route('admin.permissions.index'),
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findorfail($id);
        return view('admin.permissions.edit-modal', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $permission = $this->permissionService->update($request,$id);

            return response()->json(
                [
                    'message' => 'Action was successfull',
                    'url' => route('admin.permissions.index'),
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
