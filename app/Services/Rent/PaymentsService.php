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
use App\Models\Rent\Payment;
use App\Models\Rent\PaymentItem;
use DB;
use App\Http\Requests\Rent\PaymentPost;
use App\Models\Rent\PaymentSchedule;
use App\Models\Rent\TenantUnit;
use App\Http\Requests\Main\FileUploadPost;
use App\Services\Accounts\iCurrencyService;
use Illuminate\Support\Facades\Route;
use App\Models\Rent\Ledger;

class PaymentsService implements iPaymentsService
{

    protected $currencyService;
    public function __construct(iCurrencyService $currencyService)
    {
    $this->currencyService = $currencyService;
    }

    public function create(PaymentPost $request)
    {

        DB::beginTransaction();
        try {

            $paidamount =   str_replace(',', '', $request->paid);
            $amountdue =   preg_replace("/[^0-9]/", "", $request->amount_due);
            $date = Carbon::createFromFormat('d/m/Y', $request->date);
            $tenantunit =    TenantUnit::findorfail($request->tenant_unit_id);

            $conversionamount =  $this->currencyService->convert($tenantunit->currency_id, $request->paid);
            $conversion_amountdue =  $this->currencyService->convert($tenantunit->currency_id, $amountdue);

            $payment = new Payment();
            $payment->amount = $paidamount;
            $payment->foreign_amount = $conversionamount[1];
            $payment->base_amount = $conversionamount[2];
            $payment->date = $date;
            $payment->amount_due = $amountdue;
            $payment->foreign_amount_due= $conversion_amountdue[1];
            $payment->base_amount_due = $conversion_amountdue[2];

            $payment->tenant_unit_id  = $request->tenant_unit_id;
            $payment->account_id  = $request->account_id;
            $payment->invoice_id  = $request->invoice_id;
            $payment->payment_mode_id  = $request->payment_mode_id;
            $payment->property_id  = $request->property_id;
            $payment->created_by = Auth::id();
            $payment->save();


            $i = 0;
            $len = count($request->payment_schedule_id);

            $array = $request->payment_schedule_id;
            $dates = [];
            foreach ($array as $key => $paymentschedule) {
                $previous_schedule_id = null;
                $currentschedule = PaymentSchedule::findOrFail($paymentschedule);

                if ($key > 0) {
                   $previous_schedule_id = $array[$key-1];
               }

               if(empty($previous_schedule_id)){
                   //if previous is is null
                    if($currentschedule->balance > $paidamount){
                        $paid = $paidamount;
                        $balance = $currentschedule->balance - $paidamount;
                        $balance_c_forward = 0;
                    } else  if($currentschedule->balance < $paidamount){
                        $paid =  $currentschedule->discount_amount;
                        $balance = 0;
                        $balance_c_forward =  $paidamount - $currentschedule->balance;
                    } else if($currentschedule->balance = $paidamount){
                        $paid =  $currentschedule->discount_amount;
                        $balance = 0;
                        $balance_c_forward =  0;
                    }

               }  else {

                $previousschedule = PaymentSchedule::findOrFail($previous_schedule_id);
                $balance_b_forward = $previousschedule->balance_c_forward;

                if($currentschedule->balance > $balance_b_forward){
                    $paid = $balance_b_forward;
                    $balance = $currentschedule->balance - $balance_b_forward;
                    $balance_c_forward = 0;
                } else  if($currentschedule->balance < $balance_b_forward){
                    $paid =  $currentschedule->discount_amount;
                    $balance = 0;
                    $balance_c_forward =  $balance_b_forward - $currentschedule->balance;
                } else if($currentschedule->balance = $balance_b_forward){
                    $paid =  $currentschedule->discount_amount;
                    $balance = 0;
                    $balance_c_forward =  0;
                }

               }


               $conversion =  $this->currencyService->convert($tenantunit->currency_id, $paid);
               $conversion_balance =  $this->currencyService->convert($tenantunit->currency_id, $balance);

               $currentschedule->paid  = $paid;
               $currentschedule->converted_paid  = $conversion[0];
               $currentschedule->foreign_paid = $conversion[1];
               $currentschedule->base_paid = $conversion[2];

               $currentschedule->balance_c_forward  = $balance_c_forward;

               $currentschedule->balance  = $balance;
               $currentschedule->converted_balance  = $conversion_balance[0];
               $currentschedule->foreign_balance = $conversion_balance[1];
               $currentschedule->base_balance = $conversion_balance[2];


               $currentschedule->updated_by = Auth::id();
               $currentschedule->save();

               $paymentitem = new PaymentItem();
               $paymentitem->paid  = $paid;
               $paymentitem->foreign_paid = $conversion[1];
               $paymentitem->base_paid = $conversion[2];

               $paymentitem->balance  = $balance;
               $paymentitem->foreign_balance = $conversion_balance[1];
               $paymentitem->base_balance = $conversion_balance[2];
               $paymentitem->payment_id  = $payment->id;
               $paymentitem->payment_schedule_id  = $currentschedule->id;
               $paymentitem->created_by = Auth::id();
               $paymentitem->save();

            if ($paymentitem->from_date && $paymentitem->to_date) {
        $dates[] = '('. $paymentitem->from_date . ' - ' . $paymentitem->to_date .')';
                }

               if($currentschedule->payment_terms_amount >0){

                if($currentschedule->tenantunit->period->code == 'MONTHLY'){
                    $addedterms = $currentschedule->tenantunit->terms + 1;
                    $projectiontodate = Carbon::createFromFormat('Y-m-d', $currentschedule->from_date)->addMonths($addedterms)->format('Y-m-d');
                } else if($currentschedule->tenantunit->period->code == 'YEARLY'){
                    $addedterms = $currentschedule->tenantunit->terms + 1;
                    $projectiontodate = Carbon::createFromFormat('Y-m-d', $currentschedule->from_date)->addYears($addedterms)->format('Y-m-d');
                } else if($currentschedule->tenantunit->period->code == 'WEEKLY'){
                    $addedterms = $currentschedule->tenantunit->terms + 1;
                    $projectiontodate = Carbon::createFromFormat('Y-m-d', $currentschedule->from_date)->addDays($addedterms)->format('Y-m-d');
                } else if($currentschedule->tenantunit->period->code == 'DAILY'){
                    $addedterms = $currentschedule->tenantunit->terms + 1;
                    $projectiontodate = Carbon::createFromFormat('Y-m-d', $currentschedule->from_date)->addWeeks($addedterms)->format('Y-m-d');
                }

                $fromldate = Carbon::createFromFormat('Y-m-d', $currentschedule->from_date)->formatLocalized('%d %b,%y');
                $projectoltodate = Carbon::createFromFormat('Y-m-d', $projectiontodate)->formatLocalized('%d %b,%y');


               }

            }

                $ledger = new Ledger();
                $ledger->date = $date;
                $ledger->payment_id = $payment->id;
                $ledger->item = 'Rent Payment';
                $ledger->description = implode(', ', $dates);
                $ledger->debit = 0;
                $ledger->tenant_unit_id = $tenantunit->id;
                $ledger->credit = $paidamount;
                $ledger->created_by = Auth::id();
                $ledger->save();

            DB::commit();

            return $payment;


        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return Payment::findOrFail($id);

    }

    public function list(int $id)
    {
        $payments = Payment::with(['property'])->where('property_id',$id);
        return $payments->latest()->orderBy('id', 'desc')->get();
    }

    public function delete(int $id)
    {
        $payment = Payment::findorfail($id);
        foreach($payment->items as $paymentitem){
        $schedule = PaymentSchedule::findorfail($paymentitem->payment_schedule_id);

        if($schedule->paid > $paymentitem->paid){
        $paid = $schedule->paid - $paymentitem->paid;
        $balance = $schedule->discount_amount - $paid;
        } else {
        $paid = 0;
        $balance = $schedule->discount_amount;
        }

        $schedule->paid  = $paid;
        $schedule->balance_c_forward  = 0;
        $schedule->balance  = $balance;
        $schedule->updated_by = Auth::id();
        $schedule->save();
          }

          $payment->items()->delete();
          $payment->delete();

        DB::beginTransaction();

        try {

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }



}
