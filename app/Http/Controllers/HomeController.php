<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Reports\iReportService;
use Carbon\Carbon;
use App\Models\Rent\Expense;
use App\Models\Rent\Payment;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\Unit;
use App\Models\Rent\Property;
use App\Models\Rent\Period;
use App\Models\CRM\Client;
use App\Models\Rent\PaymentSchedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     protected $reportService;
    public function __construct(iReportService $reportService)
    {
        $this->middleware('auth');
        $this->reportService = $reportService;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $graphdata = $this->reportService->revenue( $request);
        $logs = $graphdata[0];
        $payments = $graphdata[1];

        $totalproperties = Property::all()->count();
        $tenantunitsids = TenantUnit::all()->pluck('tenant_id');;
        $tenants = Client::whereIn('id',$tenantunitsids)->get();
        $totaltenants =  $tenants->count();

        $units = Unit::all();
        $totaloccupiedunits  = Unit::where('is_available',0)->count();
        $totalvacantunits= Unit::where('is_available','>',0)->count();
        $totalunits = $units->count();

        $paymentstotal = Payment::sum('amount');
        $totalbalance = PaymentSchedule::sum('balance');
        $totalexpenses = Expense::sum('amount');

        $thismonth = Carbon::now()->format('Y-m-d');
        $lastmonth = Carbon::now()->subMonth()->format('Y-m-d');
        $lastmonthval  =  Carbon::createFromFormat('Y-m-d', $lastmonth)->startOfMonth();
        $lastmonth  =  $lastmonthval->format('Y-m-d');

        $ids =  array(1,2,3,4,5,6,7,8,9,10,11);
        $array = collect($ids);
        $lstmonth = $lastmonthval;
        $dates = $array->map(function($value) use ($lstmonth){
        $m =  $lstmonth->format('Y-m-d');
                return  Carbon::createFromFormat('Y-m-d', $m)->subMonth($value)->format('Y-m-d');
        });

        $properties = Property::all();
        $dates = $dates;

        $leasestats = $this->reportService->leaseIndexStats();

        $lease30 = $leasestats[0];
        $lease30to60 = $leasestats[1];
        $lease60to90 = $leasestats[2];


        return view('home',['revenue'=>$logs,'payments'=>$payments,'totalproperties'=>$totalproperties,'totaltenants'=>$totaltenants,'totaloccupiedunits'=>$totaloccupiedunits,'totalvacantunits'=>$totalvacantunits,'totalunits'=>$totalunits,'paymentstotal'=>$paymentstotal,'totalbalance'=>$totalbalance,'dates'=>$dates,'thismonth'=>$thismonth,'lastmonth'=>$lastmonth,'properties'=>$properties,'lease30'=> $lease30,'lease30to60'=>$lease30to60,'lease60to90'=>$lease60to90,'totalexpenses'=>$totalexpenses]);
    }


    public function guestportal()
    {
        return view('home');
    }

}
