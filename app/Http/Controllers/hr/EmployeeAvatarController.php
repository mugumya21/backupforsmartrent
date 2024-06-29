<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\EmployeeAvatar;
use App\Models\User;
use Validator;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;


class EmployeeAvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create(Request $request)
    {


        $input = $request->all();

        $rules = ['imageUpload' => 'required'];
        $messages = [];
        $validator = Validator::make($request->all() , $rules, $messages);
        if ($validator->fails())
        {
            $arr = array( "status" => 400, "msg" => $validator->errors() ->first(), "result" => array());
        }
        else
        {
            try
            {
                if ($input['base64image'] || $input['base64image'] != '0') {

                    $folderPath = public_path('uploads/employeeavatars/');
                    $image_parts = explode(";base64,", $input['base64image']);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    // $file = $folderPath . uniqid() . '.png';
                    $filename = time() . '.'. $image_type;
                    $file =$folderPath.$filename;
                    file_put_contents($file, $image_base64);

                    $avatar = new EmployeeAvatar();
                    $avatar->extension = 'jpg';
                    $avatar->name = $filename;
                    $avatar->employee_id = $request->docid;
                    $avatar->mime_type = 'image/jpeg';
                    $avatar->size = '200';
                    $avatar->created_by = Auth::id();
                    $avatar->save();
                    DB::commit();

                }

                Session::flash('success','uploaded successfully');
            }
            catch(\Illuminate\Database\QueryException $ex)
            {

            }
            catch(Exception $ex)
            {

            }
        }


        $user = User::findorfail($request->docid);

        return redirect()->route('admin.users.show', $user);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
