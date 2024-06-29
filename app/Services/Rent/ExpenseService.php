<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 05/04/2018
 * Time: 20:45
 */

namespace App\Services\Rent;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Requests\Rent\ExpensePost;
use App\Models\Rent\Expense;
use App\Models\Rent\ExpenseAction;
use App\Models\Rent\ExpenseStatus;
use App\Http\Requests\Main\FileUploadPost;
use Illuminate\Http\Request;


use App\Services\Accounts\iCurrencyService;


class ExpenseService implements iExpenseService
{

    protected $currencyService;

    public function __construct(iCurrencyService $currencyService)
    {
    $this->currencyService = $currencyService;
}
  
    public function create(ExpensePost $request)
    {
       
        $conversion =  $this->currencyService->convert($request->currency_id, $request->amount);
        $expenseStatus = ExpenseStatus::where('code', 'SUBMITTED')->first();
        if (!$expenseStatus) throw new Exception('Expense status with code APPROVED not found in system.');


        DB::beginTransaction();
        try {
      

            $expense = new Expense();
            $expense->amount = str_replace(',', '', $request->amount);
            $expense->converted_amount = $conversion[0];
            $expense->foreign_amount = $conversion[1];
            $expense->base_amount = $conversion[2];

            $expense->date = Carbon::createFromFormat('d/m/Y', $request->date);
            $expense->unit_id  = $request->unit_id;
            $expense->category_id  = $request->category_id;
            $expense->currency_id  = $request->currency_id;
            $expense->expense_status_id = $expenseStatus->id;
            $expense->property_id  = $request->property_id;
            $expense->description  = $request->description;
            $expense->created_by = Auth::id();
            $expense->save();

            DB::commit();

            return $expense;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }  
    }

    public function get(int $id)
    {
        return Expense::findOrFail($id);

    }

    public function list(int $id)
    {
        $expenses = Expense::with(['property'])->where('property_id',$id);
        return $expenses->latest()->orderBy('id', 'desc')->get();
    }



    public function update(ExpensePost $request, int $id)
    {
       
        $conversion =  $this->currencyService->convert($request->currency_id, $request->amount);

        DB::beginTransaction();
        try {

            $expense = Expense::findorfail($id);
            $expense->amount = str_replace(',', '', $request->amount);
            $expense->converted_amount = $conversion[0];
            $expense->foreign_amount = $conversion[1];
            $expense->base_amount = $conversion[2];
            $expense->date = Carbon::createFromFormat('d/m/Y', $request->date);
            $expense->unit_id  = $request->unit_id;
            $expense->category_id  = $request->category_id;
            $expense->currency_id  = $request->currency_id;
            $expense->property_id  = $request->property_id;
            $expense->description  = $request->description;
            $expense->updated_by = Auth::id();
            $expense->save();
            
            DB::commit();
            return $expense;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }  
    }




    public function approveSubmit(Request $request, int $id)
    {
        $expenseStatus = ExpenseStatus::where('code', 'APPROVED')->first();
        if (!$expenseStatus) throw new Exception('Expense status with code APPROVED not found in system.');

        DB::beginTransaction();
        try {
            $expense = Expense::findorfail($id);
            $expense->expense_status_id  = $expenseStatus->id;
            $expense->updated_by = Auth::id();
            $expense->save();

            $expenseAction = new ExpenseAction();
            $expenseAction->comment = $request->comment;
            $expenseAction->expense_status_id = $expenseStatus->id;
            $expenseAction->expense_id = $expense->id;
            $expenseAction->created_by = Auth::id();
            $expenseAction->save();

            DB::commit();
            return $expense;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }  
    }


    public function delete(int $id)
    {
        $expense = Expense::findorfail($id);
        $expense->expenseActions()->delete();
        $expense->delete();
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }



}
