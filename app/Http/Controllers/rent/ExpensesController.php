<?php

namespace App\Http\Controllers\Rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Main\iFileUploadService;
use App\Services\Rent\iExpenseService;
use App\Models\Rent\Expense;
use App\Models\Rent\ExpenseCategory;
use App\Models\Rent\Unit;
use App\Models\Rent\Property;
use App\Models\Accounts\Currency;
use App\Models\System\Setting;
use App\Http\Requests\Rent\ExpensePost;
use App\Models\Main\Document;
use App\Models\Main\DocumentType;
use Carbon\Carbon;
use App\Services\Accounts\iCurrencyService;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $expenseService;
     protected $fileUploadService;
     protected $currencyService;

     public function __construct(iExpenseService $expenseService, iFileUploadService $fileUploadService, iCurrencyService $currencyService)
     {
         $this->expenseService = $expenseService;
         $this->fileUploadService = $fileUploadService;
         $this->currencyService = $currencyService;

     }

    public function index(int $id)
    {
        $expenses = $this->expenseService->list($id);
        $property = Property::findorfail($id);
        if (Route::current()->middleware()[0] == "api") {

            return response()->json([
                'expenses' => $expenses,


            ], 200);
        }
        return view('rent.expenses.index', ['expenses' => $expenses,'property'=>$property]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id)
    {
        $expense = new Expense();
        $units = Unit::where('property_id',$id)->get();
        $categories = ExpenseCategory::all();
        $currencies = $this->currencyService->list();
        $basecurrency = $this->currencyService->baseCurrency();
        $expense->currency_id = $basecurrency->id;
        $expense->propertyid = $id;
        $expense->date =  Carbon::now()->format('Y-m-d');

        if (Route::current()->middleware()[0] == "api") {

            return response()->json([
                'units' => $units,
                'categories' => $categories,
                'currencies' => $currencies,



            ], 200);
        }

        return view('rent.expenses.create-modal', ['expense' => $expense,'units'=>$units,'categories'=>$categories,'currencies'=>$currencies]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(ExpensePost $request)
    {
        try {
            $expenses = $this->expenseService->create($request);
            if (Route::current()->middleware()[0] == "api") {

                return response()->json([
                    'expenses' => $expenses,

                ], 201);
            }
            return response()->json(
                [
                    'message' => 'success',
                    'url' => route('rent.expenses.list', $request->property_id),
                    'target' => '#expense-tab-loader'
                ], 200);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return response()->json(
                [
                    'errors' => [$e->getMessage()],
                    'url' => '',
                ], 400);
        }
    }


    public function approve(int $id)
    {
    $expense = $this->expenseService->get($id);
    return view('rent.expenses.approve-modal', ['expense' => $expense]);
    }

    public function approveSubmit(Request $request, int $id)
    {
    $expense = $this->expenseService->approveSubmit($request, $id);
    return redirect()->route('rent.expenses.show', $expense);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $expense = $this->expenseService->get($id);
        $doctype = DocumentType::where('code','EXPENSES')->first();
        $attachments = Document::where('external_key', $id)->where('document_type_id', $doctype->id)->get();
        $docid = $id;
        $filetype = $doctype->id;
        if (Route::current()->middleware()[0] == "api") {

            return response()->json([
                'expense' => $expense,

            ], 200);
        }
        return view('rent.expenses.show', ['expense' => $expense,'expense'=>$expense,'attachments'=>$attachments,'filetype'=>$filetype,'docid'=>$docid]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['edit_expenses'])){
            abort(401);
        }
        $expense = Expense::findorfail($id);
        $units = Unit::where('property_id',$expense->property_id)->get();
        $categories = ExpenseCategory::all();
        $currencies = $this->currencyService->list();

        return view('rent.expenses.edit-modal', ['expense' => $expense,'units'=>$units,'categories'=>$categories,'currencies'=>$currencies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensePost $request, string $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['edit_expenses'])){
            abort(401);
        }

            try {

                $expense = $this->expenseService->update($request,$id);
                if (Route::current()->middleware()[0] == "api") {

                    return response()->json([
                        'expense' => $expense,

                    ], 200);
                }
                Session::flash('success','Expense updated successfully');
                return redirect()->route('rent.expenses.show', $expense);
            } catch (Exception $e) {
                Log::debug($e);
                Session::flash('error','Oops! something went wrong.');
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function documents($id)
    {

        $expense = $this->expenseService->get($id);
        $documents = $expense->documents();

        return view('documents.documents-table', ['documents' => $documents]);
    }


    public function delete(string $id)
    {

        if(!Auth::user()->hasAnyDirectPermission(['delete_expenses'])){
            abort(401);
        }

      $expense =  Expense::findorfail($id);
      $property =  Property::where('id', $expense->property_id)->first();
      $this->expenseService->delete($id);
      Session::flash('success','expense was deleted!');
      return redirect()->route('rent.properties.show',$property);

    }


}
