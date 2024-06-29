<?php

namespace App\Http\Controllers\Rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Rent\iPaymentScheduleService;
use App\Models\Rent\PaymentSchedule;
use App\Models\Rent\TenantUnit;
use App\Models\Accounts\Currency;
Use DB;
use Illuminate\Support\Facades\Route;

class PaymentScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $paymentScheduleService;

     public function __construct(iPaymentScheduleService $paymentScheduleService)
     {
         $this->paymentScheduleService = $paymentScheduleService;
     }



    public function index(int $id)
    {

        $paymentschedules = $this->paymentScheduleService->list($id);
        if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                 $paymentschedules
        );
        }
        return view('rent.paymentscedules.index', ['paymentschedules' => $paymentschedules]);
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


    public function gettenantunitschedules(int $id)
    {
       $results = PaymentSchedule::select(DB::raw("DATE_FORMAT(from_date, '%d %b, %y') as fromdate"),DB::raw("DATE_FORMAT(to_date, '%d %b, %y') as todate"),DB::raw("FORMAT(balance, 0) as balance"), 'id')->where('tenant_unit_id', $id)->where('balance','>',0)->orderBy('from_date', 'ASC')->get();

        $data = '{"releases":'.$results.'}';
     if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                 $results
          );
        }
        return $data;
    }

    public function computedueamount(Request $request)
    {


        $array = collect($request->ids);
        $balances = $array->map(function($id) {
        $paymentschedule =  PaymentSchedule::where('id',$id)->first();
        $balance = $paymentschedule->balance;

        return $balance;

        });

        $sum_balances = number_format($balances->sum(), 0);
        $tenantunit = TenantUnit::where('id',$request->t_unit_id)->first();
        $currency = Currency::where('id',$tenantunit->currency_id)->first();

        $data = $currency->code.' '.$sum_balances;

        return response()->json([
        'amount'=>$data,
        'amountfull'=>$sum_balances]);
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
