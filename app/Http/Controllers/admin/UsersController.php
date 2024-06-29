<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\Admin\iUserService;
use App\Models\User;
use App\Models\Admin\Branch;
use App\Models\HR\MaritalStatus;
use App\Models\HR\Employee;
use App\Http\Requests\HR\UserEmployeePost;
use Illuminate\Support\Facades\Session;
use DB;
use Carbon\Carbon;
use App\Models\Main\DocumentType;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Services\Accounts\iCurrencyService;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService;
    public $successStatus = 200;/**
    * login api
    *
    * @return \Illuminate\Http\Response
    */


    public function __construct(iUserService $userService, iCurrencyService $currencyService)
    {
        $this->userService = $userService;
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }

        $users = $this->userService->list();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                $users
            );
        }

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }


        $user = new User();
        $branches = Branch::where('is_active', 1)->get();
        $maritalstatuses = MaritalStatus::all();
        $roles = Role::all();

        if(Route::current()->middleware()[0]=="api") {

            return response()->json([
                'branches'=>$branches,
                'maritalstatuses'=>$maritalstatuses
            ]

            );
        }
        return view('admin.users.create', ['user' => $user,'branches'=>$branches,'maritalstatuses'=>$maritalstatuses,'roles'=>$roles]);
    }


    public function changepassword(int $id)
    {
        $user = User::findorfail($id);
        return view('admin.users.changepassword-modal', ['user' => $user]);

    }


    public function changepasswordSubmit(Request $request)
    {




        // $this->validate($request, [
        //     'old_password' => ['required','current_password'],
        //     'password' => 'required|min:6',
        //     'password_confirmation' => 'required_with:password|same:password|min:6'
        // ]);


        try {


            $messages = [
                "old_password.required" => "Old password is required",
                "password.confirmed" => "The password do not match",
                "password.required" => "Password is required",
                "password.min" => "Password must be at least 6 characters"
            ];

            // validate the form data
            $validator = Validator::make($request->all(), [
                'old_password' => ['required','current_password'],
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required_with:password|same:password|min:6'
            ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user = $this->userService->changepassword($request);
        if(Route::current()->middleware()[0]=="api") {

                return response()->json(

                    [
                    "msg"=>"password changed successfully"

                    ]
                );
            }
        }



            Session::flash('success','');
            return redirect()->route('admin.users.show', $user);
        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            Log::debug($e);
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }

            try {

                $user = $this->userService->create($request);
                if(Route::current()->middleware()[0]=="api") {

                    return response()->json(

                        $user

                    );
                }
                Session::flash('success','');
                return redirect()->route('admin.users.show', $user);
            } catch (Exception $e) {
                // return some other error, or rethrow as above.
                Log::debug($e);
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }

    }

    public function assignrole(int $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }
        $user = User::findorfail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $currentroles = $user->userRoles();

        return view('admin.users.assignrole-modal', ['user' => $user,'roles'=>$roles,'currentroles'=>$currentroles]);
    }

    public function assignroleSubmit(Request $request)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }
        try {
        $user = $this->userService->assignroleSubmit($request);
        Session::flash('success','');
        return redirect()->route('admin.users.show', $user);
        } catch (Exception $e) {
            Log::debug($e);
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }


    public function assignpermission(int $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }
        $user = User::findorfail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $currentpermissions = $user->getAllPermissions();
        return view('admin.users.assignpermissions-modal', ['user' => $user,'roles'=>$roles,'permissions'=>$permissions,'currentpermissions'=>$currentpermissions]);
    }

    public function assignpermissionSubmit(Request $request)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }
        try {

        $user = $this->userService->assignpermissionSubmit($request);
        Session::flash('success','User Assigned Permissions successfully');
        return redirect()->route('admin.users.show', $user);
        } catch (Exception $e) {
            Log::debug($e);
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }

    public function updatetheme(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        DB::beginTransaction();
        try {
            if($request->id == 'light'){
                $theme = 'dark';
            } else {
                $theme = 'light';
            }
            $user->theme = $theme;
            $user->save();

            DB::commit();

            return response()->json($theme);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return response()->json($data);
    }



    public function activate(int $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }

            try {

                $user = $this->userService->activate($id);
                Session::flash('success','User has been activated');
                return redirect()->route('admin.users.show', $user);
            } catch (Exception $e) {
                Session::flash('error','Oops something went wrong');
                Log::debug($e);
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }

    }



    public function deactivate(int $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['sysadmin'])){
            abort(401);
        }

            try {

                $user = $this->userService->deactivate($id);
                Session::flash('success','User has been De-Activated');
                return redirect()->route('admin.users.show', $user);
            } catch (Exception $e) {
                Session::flash('error','Oops something went wrong');
                Log::debug($e);
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }

    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->userService->get($id);
        $filetype = DocumentType::where('code','EMP')->first();
        $filetype = $filetype->id;
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions();

        $employee = Employee::where('user_id', $user->id)->first();
        $image = $employee->avatar();

        if(Route::current()->middleware()[0]=="api") {

            return response()->json(

                $user

            );
        }
        return view('admin.users.show', ['user' => $user,'docid'=>$employee->id,'filetype'=>$filetype,'image'=>$image,'roles'=>$roles,'permissions'=>$permissions]);

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

    public function login(){
        $user = $this->userService->getByEmail(request('email'));

        if(!$user){
            return response()->json([ 'success'=>false,'message'=>'USER_NOT_FOUND'], 500);
        }


        if($user && !Hash::check(request('password'), $user->password)){

            return response()->json([ 'success'=>false,'message'=>'WRONG_PASSWORD_PROVIDED'], 500);
        }

//        $isFirstTimeLogin = ($user->last_login_ip === null);
//
//        if ($isFirstTimeLogin) {
//            return response()->json([ 'success'=>false,"email"=>request('email'),'message'=>'FIRST_TIME_LOGIN_CHANGE_PASSWORD'], 200);
//        }



        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

            $basecurrency = $this->currencyService->baseCurrency();
            $basecurrencycode = $basecurrency->code;
            $app_url = url('/') . '/uploads/letterheads/leterhead.jpg';

            $user = Auth::user();

            $success['token'] =  $user->createToken('MyApp')->accessToken;

            return response()->json([
                'success' => true,
                'base_currency_code' => $basecurrencycode,
                'letter_head' => $app_url,
                'token' => $success['token'],
                ' user' =>  $user,


            ], $this->successStatus);

        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }


    protected function guard()
    {
        return Auth::guard();
    }

    public function logout()
    {
        if (Auth::user()) {
            if(Auth::user()->AauthAcessToken()->delete()
            ){
                return response()->json([ 'success'=>true,'message'=>'Logged Out Successfully'], 200);
            }
        }
    }

    public function sync_users()
    {
        // function to make sure users are in sync with the app auth database
        $users = DB::table('users')
            ->where('is_active', '=', 1)
            ->whereNotIn('email', ['admin@example.com', 'system@smartcase.co.ug'])

            ->get();
        $app_url = url('/');

        $endpoint = 'https://app.smartrentmanager.com/api/register/new';
        try {
            $response = Http::post($endpoint, [
                'users' =>$users,
                'app_url'=>$app_url
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $response->json();


    }
}
