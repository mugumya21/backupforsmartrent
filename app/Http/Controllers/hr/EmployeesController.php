<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HR\iEmployeeService;
use App\Http\Requests\HR\EmployeeAvatarPost;
use Illuminate\Support\Facades\Route;
use Exception;
class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $employeeService;

    public function __construct(iEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;

    }


    public function index()
    {
        $users = $this->employeeService->list();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                $users
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function update_avatar(int $id)
    {
        $employee = $this->employeeService->get($id);
        if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                $employee
            );
        }
        return view('hr.employees.update-avatar', ['employee' => $employee]);
    }

    public function update_avatarSubmit(EmployeeAvatarPost $request)
    {

        try {

            $employeeAvatar = $this->employeeService->uploadAvatar($request);
            $employee = $this->employeeService->get($request->employee_id);
            if (Route::current()->middleware()[0] == "api"){
                return response()->json(
                    [
                    'success'=>true,
                    'message'=>'UPLOAD_SUCCESSFUL',
                    'avatar' => $employeeAvatar
                    ]);
                }
            Session::flash('success','');
            return redirect()->route('hr.users.show', $employee->user->id);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
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
