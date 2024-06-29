<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 05/04/2018
 * Time: 20:45
 */

namespace App\Services\Reports;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Rent\TenantUnitPost;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\PaymentSchedule;
use App\Models\Rent\Period;
use App\Models\Rent\Expense;
use App\Models\Rent\Payment;
use App\Models\Rent\Unit;
use Illuminate\Http\Request;
use DB;
use App\Models\Rent\Property;
use App\Models\Rent\Ledger;

class ReportService implements iReportService
{
    public function create()
    {

    }

    public function unpaidrent(Request $request)
    {
        $schedules =  PaymentSchedule::with(['tenantunit.currency','Unit','tenantunit.tenant.clientProfiles']);
        $date = Carbon::now()->subdays(1);
        $schedules = $schedules->where('from_date','<',$date)->where('balance','>',0);


        if($request->property_id){
              $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                    $q->where('property_id', $request->property_id);
            });
        }

        if($request->from){
            $schedules = $schedules->whereBetween('from_date', [$request->from, $request->to]);
        }

        if($request->period_date){
            $period_from =  Carbon::createFromFormat('Y-m-d', $request->period_date)->startOfMonth();
            $period_to =  Carbon::createFromFormat('Y-m-d', $request->period_date)->endOfMonth();
            $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
        }

            if($request->unit_id){
                $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                        $q->where('unit_id', $request->unit_id);
                });
            }

        if($request->tenant_id){
            $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                $q->where('tenant_id', $request->tenant_id);
        });
            }

        return $schedules->latest()->orderBy('from_date', 'desc')->get();
    }



    public function collections(Request $request)
    {
        $schedules =  PaymentSchedule::with(['tenantunit', 'tenantunit.unit','tenantunit.tenant.clientProfiles', 'unit']);

        if($request->property_id){
            $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                  $q->whereHas('unit', function ($param) use($request) {
                    $param->where('tenant_units.property_id', $request->property_id)->where('units.is_available',0);
                });
          });

$vacantunits = Unit::where('property_id', $request->property_id)->where('is_available', 1)->get();

      } else {
        $vacantunits = '';
      }

      if($request->period_date){
        $period_from =  Carbon::createFromFormat('Y-m-d', $request->period_date)->startOfMonth();
        $period_to =  Carbon::createFromFormat('Y-m-d', $request->period_date)->endOfMonth();
        $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
    }



    return array($schedules->latest()->orderBy('from_date', 'desc')->get(), $vacantunits);

}


public function projections(Request $request)
    {
        $schedules =  PaymentSchedule::with(['tenantunit', 'tenantunit.unit','tenantunit.tenant.clientProfiles', 'unit'])->where('payment_terms_amount','>',0);

        if($request->property_id){
                $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                    $q->whereHas('unit', function ($param) use($request) {
                        $param->where('tenant_units.property_id', $request->property_id)->where('units.is_available',0);
                    });
            });
        }

        if($request->period == 'MONTHLY'){

            $period_from =  Carbon::createFromFormat('Y-m-d', $request->months)->startOfMonth();
            $period_to =  Carbon::createFromFormat('Y-m-d', $request->months)->endOfMonth();

            $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);


        // $counter = 0;
        // foreach($request->months as $month){

        // $period_from =  Carbon::createFromFormat('Y-m-d', $month)->startOfMonth();
        // $period_to =  Carbon::createFromFormat('Y-m-d', $month)->endOfMonth();

        //  $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);

        // // if( $counter == 0 ) {
        // // $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
        // // } else {
        // // $schedules = $schedules->orwhereBetween('from_date', [$period_from, $period_to]);
        // // }

        //     }
        } else  if($request->period == 'ANNUALLY'){

            $startyear = ''.$request->years.'-01-01';

            $period_from =  Carbon::createFromFormat('Y-m-d', $startyear)->startOfYear();
            $period_to =  Carbon::createFromFormat('Y-m-d', $startyear)->endOfYear();

            $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);



            // $counter = 0;
            // foreach($request->years as $year){

            // $startyear = ''.$year.'-01-01';

            // $period_from =  Carbon::createFromFormat('Y-m-d', $startyear)->startOfYear();
            // $period_to =  Carbon::createFromFormat('Y-m-d', $startyear)->endOfYear();

            // $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);

            // // if( $counter == 0 ) {
            // // $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
            // // } else {
            // // $schedules = $schedules->orwhereBetween('from_date', [$period_from, $period_to]);
            // // }

            //     }
        }

        return $schedules->latest()->orderBy('from_date', 'desc')->get();
}




public function ledgers(Request $request)
{

  $currentdate = Carbon::now()->format('Y-m-d');
  $ledgers = Ledger::with(['tenantunit'])
    ->where('tenant_unit_id', $request->tenant_unit_id)
    ->where('date', '<=', $currentdate)
    ->orderBy('date', 'asc') // Sort by date descending
    ->get();

  return $ledgers;
}

public function generalprojections(Request $request)
    {

        $properties = Property::with(['tenantunits']);

        $properties = $properties->whereHas('tenantunits', function ($q) use($request) {
            $q->whereHas('schedules', function ($param) use($request) {
                $param->where('payment_schedules.payment_terms_amount','>', 0);
            });
    });

        // if($request->period == 'MONTHLY'){

        // $counter = 0;
        // foreach($request->months as $month){

        // $period_from =  Carbon::createFromFormat('Y-m-d', $month)->startOfMonth();
        // $period_to =  Carbon::createFromFormat('Y-m-d', $month)->endOfMonth();

        //  $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);

        // // if( $counter == 0 ) {
        // // $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
        // // } else {
        // // $schedules = $schedules->orwhereBetween('from_date', [$period_from, $period_to]);
        // // }

        //     }
        // }
        return $properties->latest()->get();
}




public function anualprojections(Request $request)
    {

        $properties = Property::with(['tenantunits']);

        $properties = $properties->whereHas('tenantunits', function ($q) use($request) {
            $q->whereHas('schedules', function ($param) use($request) {
                $param->where('payment_schedules.payment_terms_amount','>', 0);
            });
    });

        // if($request->period == 'MONTHLY'){

        // $counter = 0;
        // foreach($request->months as $month){

        // $period_from =  Carbon::createFromFormat('Y-m-d', $month)->startOfMonth();
        // $period_to =  Carbon::createFromFormat('Y-m-d', $month)->endOfMonth();

        //  $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);

        // // if( $counter == 0 ) {
        // // $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
        // // } else {
        // // $schedules = $schedules->orwhereBetween('from_date', [$period_from, $period_to]);
        // // }

        //     }
        // }
        return $properties->latest()->get();
}




public function leasestatus(Request $request)
{
$tenantunits = TenantUnit::with(['property', 'unit']);
if($request->property_id){
    $tenantunits =  $tenantunits->where('property_id',$request->property_id);
}

if($request->unit_id){
    $tenantunits =  $tenantunits->where('unit_id',$request->unit_id);
}

if($request->tenant_id){
    $tenantunits =  $tenantunits->where('tenant_id',$request->tenant_id);
}

return $tenantunits->get();

}

        public function leaseIndexStats()
        {

        $tenantunits = TenantUnit::with(['property', 'unit']);

         $from_30_days =  Carbon::now();
         $to_30_days = Carbon::now()->addDays(30);

        $to_60_days =  $to_30_days->addDays(30);
        $to_90_days =  $to_60_days->addDays(30);


         $tenantunits30days = $tenantunits->whereBetween('to_date', [$from_30_days, $to_30_days])->count();
         $tenantunits60days = $tenantunits->whereBetween('to_date', [$to_30_days, $to_60_days])->count();
         $tenantunits90days = $tenantunits->whereBetween('to_date', [$to_60_days, $to_90_days])->count();


        return array($tenantunits30days, $tenantunits60days ,$tenantunits90days);

    }

    public function payments(Request $request)
    {
        $payments =  Payment::with(['tenantunit.currency','tenantunit.unit', 'tenantunit.tenant.clientProfiles','property', 'account' , 'tenantunit.schedules']);
        // $payments =  Payment::with(['tenantunit.schedules','property', 'tenantunit.currency','tenantunit.unit', 'tenantunit.tenant.clientProfiles']);

        if($request->property_id){
            $payments = $payments->where('property_id',$request->property_id);
        }

        if($request->from){
            $payments = $payments->whereBetween('date', [$request->from, $request->to]);
        }

        if($request->period_date){
            $period_from =  Carbon::createFromFormat('Y-m-d', $request->period_date)->startOfMonth();
            $period_to =  Carbon::createFromFormat('Y-m-d', $request->period_date)->endOfMonth();
            $payments = $payments->whereBetween('date', [$period_from, $period_to]);
        }


        if($request->rental_period_date){
            $rental_period_from =  Carbon::createFromFormat('Y-m-d', $request->rental_period_date)->startOfMonth();
            $rental_period_to =  Carbon::createFromFormat('Y-m-d', $request->rental_period_date)->endOfMonth();
            $payments = $payments->whereHas('items', function ($q) use($rental_period_from,$rental_period_to) {
                $q->whereHas('schedule', function ($param) use($rental_period_from,$rental_period_to) {
                    $param->whereBetween('from_date', [$rental_period_from, $rental_period_to]);
                });
            });
        }


        if($request->unit_id){
            $payments = $payments->whereHas('tenantunit', function ($q) use($request) {
                $q->where('unit_id', $request->unit_id);
            });
        }

        if($request->tenant_id){
            $payments = $payments->whereHas('tenantunit', function ($q) use($request) {
                $q->where('tenant_id', $request->tenant_id);
            });
        }


        return $payments->latest()->orderBy('date', 'desc')->get();
    }


    public function revenue(Request $request)
    {
        $jan = Carbon::now()->startofYear();
        $feb = Carbon::now()->startofYear()->addMonths(1);
        $mar = Carbon::now()->startofYear()->addMonths(2);
        $apr = Carbon::now()->startofYear()->addMonths(3);
        $may = Carbon::now()->startofYear()->addMonths(4);
        $jun = Carbon::now()->startofYear()->addMonths(5);
        $jul = Carbon::now()->startofYear()->addMonths(6);
        $aug = Carbon::now()->startofYear()->addMonths(7);
        $sep = Carbon::now()->startofYear()->addMonths(8);
        $oct = Carbon::now()->startofYear()->addMonths(9);
        $nov = Carbon::now()->startofYear()->addMonths(10);
        $dec = Carbon::now()->startofYear()->addMonths(11);

        $Janpay =  Payment::whereBetween('date', [$jan->startofMonth()->format('Y-m-d'), $jan->endofMonth()->format('Y-m-d')])->sum('amount');
        $Janexp =  Expense::whereBetween('date', [$jan->startofMonth()->format('Y-m-d'), $jan->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Febpay =  Payment::whereBetween('date', [$feb->startofMonth()->format('Y-m-d'), $feb->endofMonth()->format('Y-m-d')])->sum('amount');
        $Febexp =  Expense::whereBetween('date', [$feb->startofMonth()->format('Y-m-d'), $feb->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Marpay =  Payment::whereBetween('date', [$mar->startofMonth()->format('Y-m-d'), $mar->endofMonth()->format('Y-m-d')])->sum('amount');
        $Marexp =  Expense::whereBetween('date', [$mar->startofMonth()->format('Y-m-d'), $mar->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Aprpay =  Payment::whereBetween('date', [$apr->startofMonth()->format('Y-m-d'), $apr->endofMonth()->format('Y-m-d')])->sum('amount');
        $Aprexp =  Expense::whereBetween('date', [$apr->startofMonth()->format('Y-m-d'), $apr->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Maypay =  Payment::whereBetween('date', [$may->startofMonth()->format('Y-m-d'), $may->endofMonth()->format('Y-m-d')])->sum('amount');
        $Mayexp =  Expense::whereBetween('date', [$may->startofMonth()->format('Y-m-d'), $may->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Junpay =  Payment::whereBetween('date', [$jun->startofMonth()->format('Y-m-d'), $jun->endofMonth()->format('Y-m-d')])->sum('amount');
        $Junexp =  Expense::whereBetween('date', [$jun->startofMonth()->format('Y-m-d'), $jun->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Julpay =  Payment::whereBetween('date', [$jul->startofMonth()->format('Y-m-d'), $jul->endofMonth()->format('Y-m-d')])->sum('amount');
        $Julexp =  Expense::whereBetween('date', [$jul->startofMonth()->format('Y-m-d'), $jul->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Augpay =  Payment::whereBetween('date', [$aug->startofMonth()->format('Y-m-d'), $aug->endofMonth()->format('Y-m-d')])->sum('amount');
        $Augexp =  Expense::whereBetween('date', [$aug->startofMonth()->format('Y-m-d'), $aug->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Seppay =  Payment::whereBetween('date', [$sep->startofMonth()->format('Y-m-d'), $sep->endofMonth()->format('Y-m-d')])->sum('amount');
        $Sepexp =  Expense::whereBetween('date', [$sep->startofMonth()->format('Y-m-d'), $sep->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Octpay =  Payment::whereBetween('date', [$oct->startofMonth()->format('Y-m-d'), $oct->endofMonth()->format('Y-m-d')])->sum('amount');
        $Octexp =  Expense::whereBetween('date', [$oct->startofMonth()->format('Y-m-d'), $oct->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Novpay =  Payment::whereBetween('date', [$nov->startofMonth()->format('Y-m-d'), $nov->endofMonth()->format('Y-m-d')])->sum('amount');
        $Novexp =  Expense::whereBetween('date', [$nov->startofMonth()->format('Y-m-d'), $nov->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $Decpay =  Payment::whereBetween('date', [$dec->startofMonth()->format('Y-m-d'), $dec->endofMonth()->format('Y-m-d')])->sum('amount');
        $Decexp =  Expense::whereBetween('date', [$dec->startofMonth()->format('Y-m-d'), $dec->endofMonth()->format('Y-m-d')])->sum('converted_amount');

        $expenses = array($Janexp,$Febexp,$Marexp,$Aprexp,$Mayexp,$Junexp,$Julexp,$Augexp,$Sepexp,$Octexp,$Novexp,$Decexp);
        $payments = array($Janpay,$Febpay,$Marpay,$Aprpay,$Maypay,$Junpay,$Julpay,$Augpay,$Seppay,$Octpay,$Novpay,$Decpay);

        return array($expenses, $payments);

    }





}
