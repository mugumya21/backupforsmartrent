<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\Unit;
use App\Models\Rent\Property;
use App\Models\Rent\Period;
use App\Models\CRM\Client;
use App\Models\Rent\Ledger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Services\Reports\iReportService;
use App\ViewModels\SearchModel;
use PDF;
use Illuminate\Support\Facades\Route;
use App\Services\Accounts\iCurrencyService;
use App\Models\Accounts\Currency;
use App\Models\System\Setting;
use App\Models\Main\Month;

use Carbon\CarbonPeriod;
use App\Models\Rent\PaymentSchedule;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $reportService;
     protected $currencyService;

     public function __construct(iReportService $reportService, iCurrencyService $currencyService)
     {
         $this->reportService = $reportService;
         $this->currencyService = $currencyService;
     }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function unpaidrent(Request $request)
    {

    $search = new SearchModel();

    $schedules = $this->reportService->unpaidrent($request);
    $properties = Property::all();
    $tenantunits = TenantUnit::all();
    $clients = Client::all();
    $units = Unit::all();
    $search = $search;

    if($request->property_id){
        $search->property_id = $request->property_id;
    } else {
        $search->property_id = '';
    }

    if($request->from){
        $search->from = $request->from;
    } else {
        $search->from = '';
    }

    if($request->to){
        $search->to = $request->to;
    } else {
        $search->to = '';
    }

    if($request->unit_id){
        $search->unit_id = $request->unit_id;
    } else {
        $search->unit_id = '';
    }

    if($request->tenant_id){
        $search->tenant_id = $request->tenant_id;
        $search->tenant_selected = Client::where('id',$request->tenant_id)->first();
    } else {
        $search->tenant_id = '';
        $search->tenant_selected =  '';
    }

    if($request->period_date){
         $search->period_date = $request->period_date;

    } else {
         $search->period_date = '';
    }

    if($request->currency_id){
        $currency = Currency::where('id',$request->currency_id)->first();
        $currency = Currency::findorfail($currency->id);
        $search->currency_id = $request->currency_id;

   } else {

    $basecurrency = $this->currencyService->baseCurrency();
    $currency = Currency::findorfail($basecurrency->id);
    $search->currency_id = $basecurrency->id;

   }

    $currencies = $this->currencyService->list();

    $search->thismonth = Carbon::now()->format('Y-m-d');
    $lastmonth = Carbon::now()->subMonth()->format('Y-m-d');
    $lastmonthval  =  Carbon::createFromFormat('Y-m-d', $lastmonth)->startOfMonth();
    $search->lastmonth  =  $lastmonthval->format('Y-m-d');

    $ids =  array(1,2,3,4,5,6,7,8,9,10,11);
    $array = collect($ids);
    $lstmonth = $lastmonthval;
    $dates = $array->map(function($value) use ($lstmonth){
      $m =  $lstmonth->format('Y-m-d');
            return  Carbon::createFromFormat('Y-m-d', $m)->subMonth($value)->format('Y-m-d');
    });

    $dates = $dates;
    $search->dates = $dates;
    if (Route::current()->middleware()[0] == "api") {
        return response()->json([
            'schedules' => $schedules,
            'properties' => $properties,
            'properties' => $properties,
            'clients' => $clients,
            'search' => $search,
            'units' => $units
        ], 200);
    }
    return view('reports.unpaidrent', ['schedules' => $schedules, 'properties' => $properties, 'tenantunits' => $tenantunits, 'properties' => $properties, 'clients'=>$clients, 'search'=>$search, 'units'=>$units,'currency'=>$currency,'currencies'=>$currencies]);

    }


    public function collectionsPrint (Request $request)
    {

    $autonumber =    Carbon::now()->format('dmYHis');
    $array = array($request->results);
    foreach($array as $item){
        return $item->id;
    }

    // $chedules = $array->map(function($item){
    //     $m =  $lstmonth->format('Y-m-d');
    //           return  Carbon::createFromFormat('Y-m-d', $m)->subMonth($value)->format('Y-m-d');
    //   });

    $pdf = PDF::loadView('reports.collections-print', ['schedules'=>$request->results]);
    $pdf->stream('collection_' . $autonumber . '_.pdf');

    }


    public function payments(Request $request)
    {

    $search = new SearchModel();
    $payments = $this->reportService->payments($request);
    $properties = Property::all();
    $tenantunits = TenantUnit::all();
    $clients = Client::all();
    $units = Unit::all();

    if($request->property_id){
        $search->property_id = $request->property_id;
    } else {
        $search->property_id = '';
    }

    if($request->from){
        $search->from = $request->from;
    } else {
        $search->from = '';
    }

    if($request->to){
        $search->to = $request->to;
    } else {
        $search->to = '';
    }

    if($request->unit_id){
        $search->unit_id = $request->unit_id;
    } else {
        $search->unit_id = '';
    }

    if($request->tenant_id){
        $search->tenant_id = $request->tenant_id;
        $search->tenant_selected = Client::where('id',$request->tenant_id)->first();
    } else {
        $search->tenant_id = '';
        $search->tenant_selected =  '';
    }


    if($request->period_date){
        $search->period_date = $request->period_date;

   } else {
        $search->period_date = '';
   }


   if($request->rental_period_date){
    $search->rental_period_date = $request->rental_period_date;

} else {
    $search->rental_period_date = '';
}

if($request->currency_id){

    $currency = Currency::where('id',$request->currency_id)->first();
    $currency = Currency::findorfail($currency->id);
    $search->currency_id = $request->currency_id;

} else {

$basecurrency = $this->currencyService->baseCurrency();
$currency = Currency::findorfail($basecurrency->id);
$search->currency_id = $basecurrency->id;

}

$currencies = $this->currencyService->list();

   $search->thismonth = Carbon::now()->format('Y-m-d');
   $lastmonth = Carbon::now()->subMonth()->format('Y-m-d');
   $lastmonthval  =  Carbon::createFromFormat('Y-m-d', $lastmonth)->startOfMonth();
   $search->lastmonth  =  $lastmonthval->format('Y-m-d');

   $ids =  array(1,2,3,4,5,6,7,8,9,10,11);
   $array = collect($ids);
   $lstmonth = $lastmonthval;
   $dates = $array->map(function($value) use ($lstmonth){
     $m =  $lstmonth->format('Y-m-d');
           return  Carbon::createFromFormat('Y-m-d', $m)->subMonth($value)->format('Y-m-d');
   });


    $dates = $dates;
    $search->dates = $dates;

    if (Route::current()->middleware()[0] == "api") {

        return response()->json([
            'payments' => $payments,
            'search' => $search
        ], 200);
    }
    return view('reports.payments', ['payments'=>$payments, 'units' => $units, 'properties' => $properties, 'tenantunits' => $tenantunits, 'properties' => $properties, 'clients'=>$clients, 'search'=>$search,'currency'=> $currency,'currencies'=>$currencies]);

    }

    public function collections(Request $request)
    {
            $search = new SearchModel();
            $collectionschedules = $this->reportService->collections($request);
            $schedules = $collectionschedules[0];
            $vacantunits = $collectionschedules[1];

            $properties = Property::all();
            $tenantunits = TenantUnit::all();
            $clients = Client::all();
            $units = Unit::all();
            $search = $search;

            if($request->property_id){
                $search->property_id = $request->property_id;
            } else {
                $search->property_id = '';
            }

            if($request->from){
                $search->from = $request->from;
            } else {
                $search->from = '';
            }

            if($request->to){
                $search->to = $request->to;
            } else {
                $search->to = '';
            }

            if($request->unit_id){
                $search->unit_id = $request->unit_id;
            } else {
                $search->unit_id = '';
            }

            if($request->tenant_id){
                $search->tenant_id = $request->tenant_id;
                $search->tenant_selected = Client::where('id',$request->tenant_id)->first();
            } else {
                $search->tenant_id = '';
                $search->tenant_selected =  '';
            }

            if($request->period_date){
                $search->period_date = $request->period_date;

           } else {
                $search->period_date = Carbon::now()->format('Y-m-d');
           }


           if($request->currency_id){

            $currency = Currency::where('id',$request->currency_id)->first();
            $currency = Currency::findorfail($currency->id);
            $search->currency_id = $request->currency_id;

       } else {

        $basecurrency = $this->currencyService->baseCurrency();
        $currency = Currency::findorfail($basecurrency->id);
        $search->currency_id = $basecurrency->id;

       }

           $search->thismonth = Carbon::now()->format('Y-m-d');
           $lastmonth = Carbon::now()->subMonth()->format('Y-m-d');
           $lastmonthval  =  Carbon::createFromFormat('Y-m-d', $lastmonth)->startOfMonth();
           $search->lastmonth  =  $lastmonthval->format('Y-m-d');

           $ids =  array(1,2,3,4,5,6,7,8,9,10,11);
           $array = collect($ids);
           $lstmonth = $lastmonthval;
           $dates = $array->map(function($value) use ($lstmonth){
             $m =  $lstmonth->format('Y-m-d');
                   return  Carbon::createFromFormat('Y-m-d', $m)->subMonth($value)->format('Y-m-d');
           });

           $dates = $dates;
           $search->dates = $dates;

        $currencies = $this->currencyService->list();

        $foreigncurrency = Setting::where('key','Foreign_Currency')->first();

        if($request->submit == 'PRINT'){
        $date = Carbon::createFromFormat('Y-m-d', $request->period_date)->formatLocalized('%B, %Y');
        $property = Property::findorfail($request->property_id);
        $autonumber =    Carbon::now()->format('dmYHis');

        $currency = Currency::where('id',$currency->id)->first();

        if($currency->code == $foreigncurrency->value){

        $totAmntDue =  $schedules->sum('foreign_discount_amount');
        $totAmntPaid =  $schedules->sum('foreign_paid');
        $totAmntUnpaid =  $schedules->sum('foreign_balance');

        } else {
        $totAmntDue =  $schedules->sum('base_discount_amount');
        $totAmntPaid =  $schedules->sum('base_paid');
        $totAmntUnpaid =  $schedules->sum('base_balance');
}


$totalunits = Unit::where('property_id',$request->property_id)->count();
$totaloccupied = Unit::where('property_id',$request->property_id)->where('is_available',0)->count();
$totalvacant = Unit::where('property_id',$request->property_id)->where('is_available',1)->count();

$pdf = PDF::loadView('reports.collections-print', ['schedules' => $schedules,'date'=>$date,'property'=>$property,'totAmntPaid'=>$totAmntPaid,'totAmntDue'=>$totAmntDue,'totAmntUnpaid'=>$totAmntUnpaid,'totalunits'=>$totalunits,'totaloccupied'=>$totaloccupied,'totalvacant'=>$totalvacant,'vacantunits'=>$vacantunits,'currency'=> $currency,'currencies'=>$currencies]);
$pdf->stream('collection_' . $autonumber . '_.pdf');

}

if (Route::current()->middleware()[0] == "api") {
    return response()->json([
        'schedules' => $schedules,
        'vacantunits' => $vacantunits,
        'currency' => $currency,
        'search' => $search,
    ], 200);
}
//  if (Route::current()->middleware()[0] == "api") {
//             $schedulew = [];
//             foreach ($schedules as $schedule) {
//                 // $formattedItems = [];
//                 // foreach ($schedule->tenantunit as $tenantunit) {
//                 //     $formattedItems[] = [
//                 //         "unpaid_amount" => $tenantunit->reportamountTotal ??,
//                 //     ];
//                 // }

//                 $formattedschedule = [
//                 "id" => $schedule->id,
//                 "from_date" => $schedule->from_date,
//                 "to_date" => $schedule->to_date,
//                 "discount_amount" => $schedule->discount_amount,
//                 "converted_discount_amount" => $schedule->converted_discount_amount,
//                 "foreign_discount_amount" => $schedule->foreign_discount_amount,
//                 "base_discount_amount" => $schedule->base_discount_amount,
//                 "paid" => $schedule->paid,
//                 "converted_paid" => $schedule->converted_paid,
//                 "foreign_paid" => $schedule->foreign_paid,
//                 "base_paid" => $schedule->base_paid,
//                 "balance" => $schedule->balance,
//                 "converted_balance" => $schedule->converted_balance,
//                 "foreign_balance" => $schedule->foreign_balance,
//                 "base_balance" => $schedule->base_balance,
//                 "balance_c_forward" => $schedule->balance_c_forward,
//                 "description" => $schedule->description,
//                 "unit_id" => $schedule->unit_id,
//                 "tenant_unit_id" => $schedule->tenant_unit_id,
//                 "schedule_id" => $schedule->schedule_id,
//                 "created_by" => $schedule->created_by,
//                 "updated_by" => $schedule->updated_by,
//                 "created_at" => $schedule->created_at,
//                 "updated_at" => $schedule->updated_at,
//                 "tenant_unit" => $schedule->tenantunit->tenant->clientProfiles,
//                 "unit" => $schedule->unit,

//                 ];

//                 $schedulew[] = $formattedschedule;
//             }

//             return response()->json([
//         'schedules' => $schedulew,
//         'vacantunits' => $vacantunits,
//         'currency' => $currency,
//         'search' => $search,
//     ], 200);
//         }

return view('reports.collections', ['schedules' => $schedules, 'properties' => $properties, 'tenantunits' => $tenantunits, 'properties' => $properties, 'clients'=>$clients, 'search'=>$search, 'allunits'=>$units,'vacantunits'=>$vacantunits,'currency'=> $currency,'currencies'=>$currencies]);
}




public function projections(Request $request)
    {

        // return $request->months;

            $search = new SearchModel();
            $schedules = $this->reportService->projections($request);

            $properties = Property::all();
            $tenantunits = TenantUnit::all();
            $search = $search;

            if($request->property_id){
                $search->property_id = $request->property_id;
            } else {
                $search->property_id = '';
            }

            if($request->months){
                $search->months =  $request->months;
               } else {
                   $search->months = '';
               }

               if($request->years){
                $search->years =  $request->years;
               } else {
                   $search->years = '';
               }

               if($request->period){
                $search->period =  $request->period;
               } else {
                   $search->period = '';
               }


           if($request->currency_id){
            $currency = Currency::where('id',$request->currency_id)->first();
            $currency = Currency::findorfail($currency->id);
            $search->currency_id = $request->currency_id;

       } else {

        $basecurrency = $this->currencyService->baseCurrency();
        $currency = Currency::findorfail($basecurrency->id);
        $search->currency_id = $basecurrency->id;

       }

        $startmonth = Carbon::now()->startofMonth()->format('Y-m-d');
        $endmonth = Carbon::now()->startofMonth()->addMonths(12)->format('Y-m-d');
        $allmonths = CarbonPeriod::create($startmonth, '1 month', $endmonth);

        $startyear = Carbon::now()->format('Y-m-d');
        $endyear = Carbon::now()->addYears(10)->format('Y-m-d');
        $years = CarbonPeriod::create($startyear, '1 year', $endyear);

        $currencies = $this->currencyService->list();

        $foreigncurrency = Setting::where('key','Foreign_Currency')->first();

        if($request->submit == 'PRINT'){
        $date = Carbon::now()->formatLocalized('%B, %Y');
        $property = Property::findorfail($request->property_id);
        $autonumber =    Carbon::now()->format('dmYHis');

        $currency = Currency::where('id',$currency->id)->first();


        if($request->period == "ANNUALLY"){
            $carymonth = $request->years;

                            } else if($request->period == "MONTHLY"){
                                $carymonth = Carbon::createFromFormat('Y-m-d', $request->months)->formatLocalized('%B, %Y');
            }


        $pdf = PDF::loadView('reports.projections-print', ['schedules' => $schedules, 'properties' => $properties, 'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'allmonths'=>$allmonths,'years'=>$years,'period'=>$request->period,'date'=>$date,'month'=>$carymonth,'property'=>$property ]);
        $pdf->stream('projection_' . $autonumber . '_.pdf');
        }

        return view('reports.projections', ['schedules' => $schedules, 'properties' => $properties, 'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'allmonths'=>$allmonths,'years'=>$years,'period'=>$request->period]);
        }



public function generalprojections(Request $request)
    {

        // return $request->months;

            $search = new SearchModel();
            $properties = $this->reportService->generalprojections($request);
            $tenantunits = TenantUnit::all();
            $search = $search;

            if($request->months){
                $search->months =  $request->months;
            } else {
                $search->months = '';
            }

            if($request->years){
                $search->years =  $request->years;
               } else {
                   $search->years = '';
               }

            if($request->period){
                $search->period =  $request->period;
               } else {
                   $search->period = '';
               }


           if($request->currency_id){
            $currency = Currency::where('id',$request->currency_id)->first();
            $currency = Currency::findorfail($currency->id);
            $search->currency_id = $request->currency_id;

       } else {

        $basecurrency = $this->currencyService->baseCurrency();
        $currency = Currency::findorfail($basecurrency->id);
        $search->currency_id = $basecurrency->id;
       }

        $startmonth = Carbon::now()->startofMonth()->format('Y-m-d');
        $endmonth = Carbon::now()->startofMonth()->addMonths(12)->format('Y-m-d');
        $months = CarbonPeriod::create($startmonth, '1 month', $endmonth);

        $startyear = Carbon::now()->format('Y-m-d');
        $endyear = Carbon::now()->addYears(10)->format('Y-m-d');
        $years = CarbonPeriod::create($startyear, '1 year', $endyear);

        $currencies = $this->currencyService->list();

        $foreigncurrency = Setting::where('key','Foreign_Currency')->first();




                $properties = $properties->map(function($property) use ($request){

                $tenantunits =  TenantUnit::where('property_id',$property->id)->get();
                $tenantunitids = $tenantunits->pluck('id');

                $schedules = PaymentSchedule::whereIn('tenant_unit_id',$tenantunitids)->where('payment_terms_amount','>',0);

                if($request->period == 'MONTHLY'){

                $period_from =  Carbon::createFromFormat('Y-m-d', $request->months)->startOfMonth();
                $period_to =  Carbon::createFromFormat('Y-m-d', $request->months)->endOfMonth();
                $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
                        }

            else  if($request->period == 'ANNUALLY'){

                $startyear = ''.$request->years.'-01-01';
                $period_from =  Carbon::createFromFormat('Y-m-d', $startyear)->startOfYear();
                $period_to =  Carbon::createFromFormat('Y-m-d', $startyear)->endOfYear();
                $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
                        }


                $property['total'] = $schedules->sum('payment_terms_amount');

                return $property;

                });

                $properties = $properties;

                $totalprojections = $properties->sum('total');


                if($request->submit == 'PRINT'){
                    $date = Carbon::now()->formatLocalized('%B, %Y');
                    $autonumber =    Carbon::now()->format('dmYHis');

$currency = Currency::where('id',$currency->id)->first();

    if($request->period == "ANNUALLY"){
    $caryyear = $request->years;
                    } else if($request->period == "MONTHLY"){
                        $caryyear = Carbon::createFromFormat('Y-m-d', $request->months)->formatLocalized('%B, %Y');
    }

        $pdf = PDF::loadView('reports.allprojections-print', ['properties' => $properties, 'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'months'=>$months,'monthval'=>$request->months,'yearval'=>$request->years,'years'=>$years,'period'=>$request->period,'date'=>$date,'caryyear'=>$caryyear,'totalprojections'=>$totalprojections ]);
        $pdf->stream('projection_' . $autonumber . '_.pdf');

            }


return view('reports.allprojections', ['properties' => $properties, 'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'months'=>$months,'monthval'=>$request->months,'yearval'=>$request->years,'years'=>$years,'period'=>$request->period]);
}



public function ledgers(Request $request)
    {

  $search = new SearchModel();
  $ledgers = $this->reportService->ledgers($request);
  $search = $search;

  if($request->tenant_unit_id){
      $search->tenant_unit_id = $request->tenant_unit_id;
  } else {
      $search->tenant_unit_id = '';
  }

  $tenantunits = TenantUnit::all();
  $properties = Property::all();


 if($request->currency_id){
  $currency = Currency::where('id',$request->currency_id)->first();
  $currency = Currency::findorfail($currency->id);
  $search->currency_id = $request->currency_id;

} else {

$basecurrency = $this->currencyService->baseCurrency();
$currency = Currency::findorfail($basecurrency->id);
$search->currency_id = $basecurrency->id;

}

$currencies = $this->currencyService->list();
$foreigncurrency = Setting::where('key','Foreign_Currency')->first();


if($request->submit == 'PRINT'){
          $date = Carbon::now()->formatLocalized('%B, %Y');
          $autonumber =    Carbon::now()->format('dmYHis');

$currency = Currency::where('id',$currency->id)->first();
 $tenantUnitDetails = [];
        if ($request->tenant_unit_id) {
            $tenantUnit = TenantUnit::with(['property', 'unit'])->find($request->tenant_unit_id);
            if ($tenantUnit) {
                $tenantUnitDetails = [
                    'property_name' => $tenantUnit->property->name,
                    'unit_name' => $tenantUnit->unit->name,
                    'tenant' => $tenantUnit->tenant->full_name,
                ];
            }
        }
// return view('reports.ledgers-print', ['ledgers' => $ledgers,'search'=>$search,'tenantunits'=>$tenantunits,'tenantUnitDetails' => $tenantUnitDetails,
// ]);

$pdf = PDF::loadView('reports.ledgers-print', ['ledgers' => $ledgers,'search'=>$search,'tenantunits'=>$tenantunits,'tenantUnitDetails' => $tenantUnitDetails,
]);
$pdf->stream('ledger_' . $autonumber . '_.pdf');
}

return view('reports.ledgers', ['ledgers' => $ledgers,'search'=>$search,'tenantunits'=>$tenantunits,'request'=>$request]);

}


public function anualprojections(Request $request)
    {

        // return $request->months;

            $search = new SearchModel();
            $properties = $this->reportService->anualprojections($request);
            $schedules =  PaymentSchedule::with(['tenantunit', 'tenantunit.unit','tenantunit.tenant.clientProfiles', 'unit'])->where('payment_terms_amount','>',0);

            if($request->property_id){
                $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                    $q->whereHas('unit', function ($param) use($request) {
                        $param->where('tenant_units.property_id', $request->property_id)->where('units.is_available',0);
                    });
            });
        }

            $tenantunits = TenantUnit::all();
            $properties = Property::all();

            $search = $search;

            if($request->property_id){
                $search->property_id = $request->property_id;
            } else {
                $search->property_id = '';
            }

            if($request->years){
                $search->years =  $request->years;
               } else {
                   $search->years = '';
               }


           if($request->currency_id){
            $currency = Currency::where('id',$request->currency_id)->first();
            $currency = Currency::findorfail($currency->id);
            $search->currency_id = $request->currency_id;

       } else {

        $basecurrency = $this->currencyService->baseCurrency();
        $currency = Currency::findorfail($basecurrency->id);
        $search->currency_id = $basecurrency->id;
       }

        $startyear = Carbon::now()->format('Y-m-d');
        $endyear = Carbon::now()->addYears(10)->format('Y-m-d');
        $years = CarbonPeriod::create($startyear, '1 year', $endyear);

        $currencies = $this->currencyService->list();

        $foreigncurrency = Setting::where('key','Foreign_Currency')->first();



        $monthtsofilter = Month::all();

        // $monthsarray = collect(range(1,12));

        $monthsarray = $monthtsofilter->map(function($filter) use ($request){

            $schedules =  PaymentSchedule::with(['tenantunit'])->where('payment_terms_amount','>',0);

            if($request->property_id){
                $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                $q->where('property_id', $request->property_id);
            });
        }

            if($request->years){
                $startdate =    $request->years.'-'.$filter->id.'-01';
            } else {
                $now = Carbon::now()->format('Y');
                $startdate = ''.$now.'-01-01';
            }

        $period_from =  Carbon::createFromFormat('Y-m-d', $startdate)->startOfMonth()->format('Y-m-d');
        $period_to =  Carbon::createFromFormat('Y-m-d', $startdate)->endOfMonth()->format('Y-m-d');
        $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);

        $filter['schedules'] = $schedules->get();
        $filter['date'] = $period_from;

        return $filter;

        });

            $monthsarray = $monthsarray;

                if($request->submit == 'PRINT'){


        $pdf = PDF::loadView('reports.anualprojections-print', ['monthsarray' => $monthsarray, 'properties'=>$properties,'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'yearval'=>$request->years,'years'=>$years]);
        $pdf->stream('Anual_projection_' . $autonumber . '_.pdf');

            }


return view('reports.anualprojections', ['monthsarray' => $monthsarray, 'properties'=>$properties,'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'yearval'=>$request->years,'years'=>$years]);
}






public function bianualprojections (Request $request)
    {


            $search = new SearchModel();


            $tenantunits = TenantUnit::all();
            $properties = Property::all();

            $search = $search;

            if($request->property_id){
                $search->property_id = $request->property_id;
            } else {
                $search->property_id = '';
            }

            if($request->months){
                $search->months =  $request->months;
               } else {
                   $search->months = '';
               }


           if($request->currency_id){
            $currency = Currency::where('id',$request->currency_id)->first();
            $currency = Currency::findorfail($currency->id);
            $search->currency_id = $request->currency_id;

       } else {

        $basecurrency = $this->currencyService->baseCurrency();
        $currency = Currency::findorfail($basecurrency->id);
        $search->currency_id = $basecurrency->id;
       }

        $startyear = Carbon::now()->format('Y-m-d');
        $endyear = Carbon::now()->addYears(10)->format('Y-m-d');
        $years = CarbonPeriod::create($startyear, '1 year', $endyear);

        $currencies = $this->currencyService->list();

        $foreigncurrency = Setting::where('key','Foreign_Currency')->first();


        if($request->months == 'JantoJun'){
            $monthtsofilter = Month::where('id','<=',6)->get();
        }  else if($request->months == 'JultoDec'){
            $monthtsofilter = Month::where('id','>',6)->get();
        } else {
            $monthtsofilter = Month::all();

        }

        // $monthsarray = collect(range(1,12));

        $monthsarray = $monthtsofilter->map(function($filter) use ($request){

            $schedules =  PaymentSchedule::with(['tenantunit', 'tenantunit.unit','tenantunit.tenant.clientProfiles', 'unit'])->where('payment_terms_amount','>',0);

            if($request->property_id){
                $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                    $q->whereHas('unit', function ($param) use($request) {
                        $param->where('tenant_units.property_id', $request->property_id)->where('units.is_available',0);
                    });
            });
        }

            $now = Carbon::now()->format('Y');
            $period_from =    $now.'-'.$filter->id.'-01';
            $period_to = Carbon::createFromFormat('Y-m-d', $period_from)->endOfMonth();

            $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
            $filter['schedules'] = $schedules->get();

             return $filter;

        });

            $monthsarray = $monthsarray;

                if($request->submit == 'PRINT'){

        $pdf = PDF::loadView('reports.bianualprojections-print', ['monthsarray' => $monthsarray, 'properties'=>$properties,'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'months'=>$request->months]);
        $pdf->stream('Bi_Anualprojection_' . $autonumber . '_.pdf');

            }


return view('reports.bianualprojections', ['monthsarray' => $monthsarray, 'properties'=>$properties,'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'months'=>$request->months]);
}

public function quaterlyprojections (Request $request)
    {

            $search = new SearchModel();

            $tenantunits = TenantUnit::all();
            $properties = Property::all();

            $search = $search;

            if($request->property_id){
                $search->property_id = $request->property_id;
            } else {
                $search->property_id = '';
            }

            if($request->months){
                $search->months =  $request->months;
               } else {
                   $search->months = '';
               }


           if($request->currency_id){
            $currency = Currency::where('id',$request->currency_id)->first();
            $currency = Currency::findorfail($currency->id);
            $search->currency_id = $request->currency_id;

       } else {

        $basecurrency = $this->currencyService->baseCurrency();
        $currency = Currency::findorfail($basecurrency->id);
        $search->currency_id = $basecurrency->id;
       }

        $startyear = Carbon::now()->format('Y-m-d');
        $endyear = Carbon::now()->addYears(10)->format('Y-m-d');
        $years = CarbonPeriod::create($startyear, '1 year', $endyear);

        $currencies = $this->currencyService->list();

        $foreigncurrency = Setting::where('key','Foreign_Currency')->first();


        if($request->months == 'Jantomar'){
            $monthtsofilter = Month::where('id','<=',3)->get();
        }  else if($request->months == 'AprtoJun'){
            $monthtsofilter = Month::where('id','>',3)->where('id','<=',6)->get();
        } else if($request->months == 'JulytoSec'){
            $monthtsofilter = Month::where('id','>',6)->where('id','<=',9)->get();
        } else if($request->months == 'OcttoDec'){
            $monthtsofilter = Month::where('id','>',9)->where('id','<=',12)->get();
        }  else {
            $monthtsofilter = Month::all();
        }

        // $monthsarray = collect(range(1,12));

        $monthsarray = $monthtsofilter->map(function($filter) use ($request){

            $schedules =  PaymentSchedule::with(['tenantunit', 'tenantunit.unit','tenantunit.tenant.clientProfiles', 'unit'])->where('payment_terms_amount','>',0);

            if($request->property_id){
                $schedules = $schedules->whereHas('tenantunit', function ($q) use($request) {
                    $q->whereHas('unit', function ($param) use($request) {
                        $param->where('tenant_units.property_id', $request->property_id)->where('units.is_available',0);
                    });
            });
        }

            $now = Carbon::now()->format('Y');
            $period_from =    $now.'-'.$filter->id.'-01';
            $period_to = Carbon::createFromFormat('Y-m-d', $period_from)->endOfMonth();

            $schedules = $schedules->whereBetween('from_date', [$period_from, $period_to]);
            $filter['schedules'] = $schedules->get();
            return $filter;

        });

            $monthsarray = $monthsarray;
            if($request->submit == 'PRINT'){

        $pdf = PDF::loadView('reports.quaterlyprojections-print', ['monthsarray' => $monthsarray, 'properties'=>$properties,'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'months'=>$request->months ]);
        $pdf->stream('projection_' . $autonumber . '_.pdf');

            }


return view('reports.quaterlyprojections', ['monthsarray' => $monthsarray, 'properties'=>$properties,'search'=>$search, 'currency'=> $currency,'currencies'=>$currencies,'months'=>$request->months]);
}



    public function leasestatus(Request $request)
    {
            $search = new SearchModel();
            $tenantunits = $this->reportService->leasestatus($request);
            $properties = Property::all();
            $clients = Client::all();
            $units = Unit::all();

            if($request->property_id){
                $search->property_id = $request->property_id;
            } else {
                $search->property_id = '';
            }

            if($request->unit_id){
                $search->unit_id = $request->unit_id;
            } else {
                $search->unit_id = '';
            }

            if($request->tenant_id){
                $search->tenant_id = $request->tenant_id;
                $search->tenant_selected = Client::where('id',$request->tenant_id)->first();
            } else {
                $search->tenant_id = '';
                $search->tenant_selected =  '';
            }

            $search = $search;

            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'properties' => $properties,
                     'tenantunits' => $tenantunits,
                     'clients' => $clients,
                     'search' => $search,
                      'units' => $units
                ]);
            }

            return view('reports.leasereport', ['properties' => $properties, 'tenantunits' => $tenantunits, 'properties' => $properties, 'clients'=>$clients, 'search'=>$search, 'units'=>$units]);

    }


    public function overview()
    {

        $totalproperties = Property::all()->count();
        $tenantunitsids = TenantUnit::all()->pluck('tenant_id');;
        $tenants = Client::whereIn('id',$tenantunitsids)->get();
        $totaltenants =  $tenants->count();
        return view('cards.overview',['totalproperties'=>$totalproperties,'totaltenants'=>$totaltenants]);

    }


    public function revenue(Request $request)
    {
        $graphdata = $this->reportService->revenue( $request);
        $logs = $graphdata[0];
        $months = $graphdata[1];
        return view('cards.revenue',['logs'=>$logs,'months'=>$logs]);
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