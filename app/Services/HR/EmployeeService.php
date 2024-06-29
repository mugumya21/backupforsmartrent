<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 06/04/2018
 * Time: 00:57
 */

namespace App\Services\HR;


use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeAvatar;
use App\Models\User;
use App\Http\Requests\HR\EmployeeAvatarPost;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeService implements iEmployeeService
{

       public function get(int $id)
    {
        return Employee::with(['user'])->find($id);
    }


    public function uploadAvatar(EmployeeAvatarPost $request)
    {
        $ext = $request->file('avatar')->getClientOriginalExtension();
        $originalAvatar = $request->file('avatar');
        $avatarImage = Image::make($originalAvatar);

        $employeeAvatar = new EmployeeAvatar();
        $employeeAvatar->extension = $ext;
        $employeeAvatar->name = $request->file('avatar')->getClientOriginalName();
        $employeeAvatar->mime_type = $request->file('avatar')->getClientMimeType();
        $employeeAvatar->size = $request->file('avatar')->getSize();
        $employeeAvatar->created_by = Auth::id();
        $employeeAvatar->employee_id = $request->employee_id;


            $basePath = "public/hr/avatars/";

            $directoryPath = storage_path() . "/app/{$basePath}" . $request->employee_id . "/";

            EmployeeAvatar::where('employee_id',$request->employee_id)->delete();

            // Get an array of all the files in the directory

            $fileList = glob($directoryPath."/*");

            // Loop through each file and delete it


            foreach ($fileList as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

        try {
            DB::beginTransaction();

            $employeeAvatar->save();
            if (!Storage::exists("{$basePath}{$request->employee_id}")) {
                Storage::makeDirectory("public/hr/avatars/{$request->employee_id}", 0777, true);
            }


            $fullPath = storage_path() . "/app/{$basePath}/";
            $avatarImage->resize(200, 200);
            $avatarImage->save("{$fullPath}{$request->employee_id}/large.{$ext}");

            $avatarImage->resize(150, 150);
            $avatarImage->save("{$fullPath}{$request->employee_id}/medium.{$ext}");

            $avatarImage->resize(50, 50);
            $avatarImage->save("{$fullPath}{$request->employee_id}/small.{$ext}");

            DB::commit();

            return asset("storage/hr/avatars/{$request->employee_id}/medium.{$employeeAvatar->extension}");

        } catch (Exception $e) {
            Log::debug($e);
            DB::rollback();
            throw $e;
        }
    }


    public function list()
    {
        $employees = Employee::with(['user','employeeAvatar']);

        $employees = $employees->whereHas('user', function ($q) {
            $q->where('is_active', true);
        });

        return $employees->latest()->get();
    }


    public function all()
    {
        $employees = Employee::with(['user']);
        $employees = $employees->whereHas('user', function ($q) {
            $q->where('is_active', '=', '1')->where('email','NOT LIKE','%admin@example.com%')->orWhere('is_active', '=', '1')->where('email','NOT LIKE','%system@smartcase.co.ug%');
        });
        return $employees->orderBy('first_name')->get();
    }


}
