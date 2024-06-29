<?php

namespace App\Services\Admin;

use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\HR\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserService implements iUserService
{


    /**
     * UserService constructor.
     */
    public function __construct()
    {
    }

    public function list()
    {
        $users = User::with(['employee'])->get();
        return $users;
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = new User();
            $user->name = $request->first_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_active = '0';
            $user->save();

            $employee = new Employee;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->middle_name = $request->middle_name;
            $employee->gender = $request->gender;
            $employee->telephone = $request->telephone;
            $employee->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
            $employee->user_id = $user->id;
            $employee->personal_email =  $request->personal_email;
            $employee->branch_id = $request->branch_id;
            $employee->permanent_address = $request->permanent_address;
            $employee->present_address = $request->present_address;
            $employee->office_number = $request->office_number;
            $employee->mobile_number = $request->mobile_number;
            $employee->marital_status_id =  $request->marital_status_id ;
            $employee->code = $request->code;
            $employee->id_number = $request->id_number;
            $employee->nssf_number = $request->nssf_number;
            $employee->tin_number = $request->tin_number;
            $employee->created_by = Auth::id();
            $employee->save();


            $role =  Role::findorfail($request->role_id);
            $permissions =  $role->permissions->pluck('name');
            $user->syncPermissions($permissions);
            $user->assignRole($role->name);


            $app_url = url('/');

            $endpoint = 'https://app.smartrentmanager.com/api/register/new';
            try {
                $response = Http::post($endpoint, [
                    'users' =>[['email'=>$user->email]],
                    'app_url'=>$app_url
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }
        


            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function assignroleSubmit(Request $request)
    {
        DB::beginTransaction();
        try {


            $user = User::findorfail($request->id);

            $ids =   $request->role_ids;
            $fetchroles = Role::whereIn('id',$ids)->get();
            $roles = $fetchroles->pluck('name');
            $user->syncRoles($roles);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function assignpermissionSubmit(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = User::findorfail($request->id);
            $ids =   $request->permissions_ids;
            $fetchpermissions = Permission::whereIn('id',$ids)->get();
            $permissions = $fetchpermissions->pluck('name');

            $user->syncPermissions($permissions);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return User::with(['employee'])->find($id);
    }

    public function getSystemUser()
    {
        return User::where('email', 'like', '%system@%')->firstOrFail();
    }


 public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = User::findorfail($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function activate(int $id)
    {
        DB::beginTransaction();
        try {

            $user = User::findorfail($id);
            $user->is_active = '1';
            $user->save();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }



    public function deactivate(int $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findorfail($id);
            $user->is_active = '0';
            $user->save();

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function getByEmail(string $email)
    {
        return User::firstWhere('email', $email);
    }

}
