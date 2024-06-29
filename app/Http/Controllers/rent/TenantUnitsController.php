<?php

namespace App\Http\Controllers\rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\Unit;
use App\Models\Rent\Property;
use App\Models\Rent\Period;
use App\Models\CRM\Client;
use App\Models\Accounts\Currency;
use App\Http\Requests\Rent\TenantUnitPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Services\Rent\iTenenatUnitService;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
use App\Services\Accounts\iCurrencyService;
use Carbon\CarbonPeriod;


class TenantUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $tenenatUnitService;
     protected $currencyService;

     public function __construct(iTenenatUnitService $tenenatUnitService, iCurrencyService $currencyService)
     {

    $this->tenenatUnitService = $tenenatUnitService;
    $this->currencyService = $currencyService;

     }



    public function index($id)
    {

        $tenantunits = $this->tenenatUnitService->tenantunitsonproperty($id);
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'tenantunitsonproperty' => $tenantunits,
            ], 201);
        }
        return view('rent.tenantunits.tenantunits-on-property', ['tenantunits' => $tenantunits]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $tenantUnit = new TenantUnit();
        $units = Unit::where('property_id',$id)->where('is_available','>',0)->get();
        $clients = Client::all();
        $periods = Period::all();
        $tenantUnit->propertyid = $id;
        $tenantUnit->schedule_id = Period::where('code', 'MONTHLY')->first();
        $currencies = Currency::all();
        $basecurrency = $this->currencyService->baseCurrency();
        $tenantUnit->currency_id  = $basecurrency->id;
        if(Route::current()->middleware()[0]=="api")
        {

            return response()->json([
                "units"=>$units,
                "clients"=>$clients,
                "periods"=>$periods,
                "currencies"=>$currencies,
                "periods"=>$periods,

            ]

           );
        }
        return view('rent.tenantunits.create-modal', ['tenantUnit' => $tenantUnit,'periods'=>$periods,'units'=>$units,'units'=>$units,'clients'=>$clients,'currencies'=>$currencies]);

    }


    public function computetodate(Request $request)
    {

        $period = Period::findOrFail($request->period);
        $code = $period->code;
        if( isset($request->period) &&  isset($request->from_date) && isset($request->specific_days)){
            $date = Carbon::createFromFormat('d/m/Y', $request->from_date);
            if($code == 'DAILY'){
                $data =  $date->addDays($request->specific_days)->format('d/m/Y');
            } else if($code == 'WEEKLY'){
                $data =  $date->addWeeks($request->specific_days)->format('d/m/Y');
            }  else if($code == 'MONTHLY'){
                $data =  $date->addMonths($request->specific_days)->format('d/m/Y');
            }  else if($code == 'YEARLY'){
                $data =  $date->addYears($request->specific_days)->format('d/m/Y');
            }  else {
                $data =  $request->$request->from_date;
            }
        } else {
            $data = '';
        }


        return response()->json($data);
    }



    public function gettenantunits(Request $request)
    {
        $data  = TenantUnit::select('id')->where('tenant_id', $request->id)->get();

        return response()->json($data);
    }


    public function gettenantunitamount(Request $request)
    {
        $tenantunit  = TenantUnit::where('id', $request->id)->first();
        $data =  $tenantunit->amount;

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantUnitPost $request)
    {
      
        try {
            $tenantunit = $this->tenenatUnitService->create($request);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'tenantunitcreated' => $tenantunit,
                ], 201);
            }

            return response()->json(
                [
                    'message' => 'success',
                    'url' => route('rent.tenantunits', $request->property_id),
                    'target' => '#tenant-tab-loader'
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        $tenantunit = $this->tenenatUnitService->get($id);

        $doctype = DocumentType::where('code','TUND')->first();
        $documents = Document::where('external_key',$id)->where('document_type_id',$doctype->id)->get();

        $docid = $id;
        $filetype = $doctype->id;

        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                 $tenantunit,
                 $filetype,
            ], 200);
        }
        return view('rent.tenantunits.show', ['tenantunit' => $tenantunit,'documents'=>$documents,'filetype'=>$filetype,'docid'=>$docid]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tenantUnit = TenantUnit::findorfail($id);
        $units = Unit::where('property_id',$tenantUnit->property_id)->where('is_available','>',0)->orwhere('id',$tenantUnit->unit_id)->get();
        $clients = Client::all();
        $tenantUnit->client = Client::where('id', $tenantUnit->tenant_id)->first();
        $periods = Period::all();
        $tenantUnit->propertyid = $tenantUnit->property_id;
        $tenantUnit->schedule_id = $tenantUnit->schedule_id;
        $tenantUnit->to_date = Carbon::createFromFormat('Y-m-d', $tenantUnit->to_date)->format('d/m/Y');
        $currencies = Currency::all();

        return view('rent.tenantunits.edit-modal', ['tenantUnit' => $tenantUnit,'periods'=>$periods,'units'=>$units,'units'=>$units,'clients'=>$clients,'currencies'=>$currencies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantUnitPost $request, int $id)
    {

        try {

            $tenantunit = $this->tenenatUnitService->update($request, $id);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                     "message"=>'tenantunit Updated successfully',

                ], 200);
            }
            Session::flash('success','');
            return redirect()->route('rent.tenantUnits.show', $tenantunit);
        } catch (Exception $e) {
            Log::debug($e);
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */

     public function delete(string $id)
     {
      $tenantunit =  TenantUnit::findorfail($id);
      $propertyid = $tenantunit->property_id;

     if($tenantunit->canEdit()){
       $this->tenenatUnitService->delete($id);
       if(Route::current()->middleware()[0]=="api"){

        return response()->json([
           'message'=> 'tenantunit deleted successfully'
        ], 200);
    }
       return redirect()->route('rent.properties.show', $propertyid);

     } else {
        Session::flash('error','');
        return redirect()->route('rent.tenantUnits.show', $tenantunit);
     }

     }
    public function destroy(string $id)
    {


    }
}
