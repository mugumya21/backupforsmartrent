<?php

namespace App\Http\Controllers\rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent\UnitType;
use App\Models\Rent\Period;
use App\Models\Rent\Unit;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\Property;
use App\Models\Rent\Floor;
use App\Models\CRM\Client;
use App\Models\Accounts\Currency;
use App\Http\Requests\Rent\unitPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Services\Rent\iUnitService;
use App\Services\Accounts\iCurrencyService;
use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Helpers\FrontEndHelper;
Use Alert;
use Auth;
use Illuminate\Support\Facades\Route;
use Exception;
class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $unitService;
     protected $currencyService;

     public function __construct(iUnitService $unitService, iCurrencyService $currencyService)
     {
         $this->unitService = $unitService;
         $this->currencyService = $currencyService;
     }


    public function index()
    {
        //
    }


    public function getunitdetails(Request $request)
    {
        $unit = Unit::findOrFail($request->id);
        $amount = $unit->amount;
        $currency  = Currency::select('name','id')->where('id', $unit->currency_id)->first();
        $tenantunit = TenantUnit::where('unit_id', $unit->id)->orderby('id','desc')->first();
        if(!empty($tenantunit)){
        $client = Client::where('id',$tenantunit->tenant_id)->first();
        $clientname = $client->full_name;
        $address = $client->currentclientProfile()->address;
        } else {
            $clientname = '';
            $client = '';
            $address = '';
            $tenantunit = '';
        }

        $response = [
            'amount' => $amount,
            'currency' => $currency,
            'clientname' => $clientname,
            'client'=>$client,
            'address' => $address,
            'tenantunit' => $tenantunit
        ];

        return response()->json($response);
    }

    public function unitsonproperty($id)
    {
        $units = $this->unitService->unitsonproperty($id);
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'units' => $units,
            ], 200);
        }
        return view('rent.units.units-on-property', ['units' => $units]);
    }


    public function getunitcurrencies(int $id)
    {
        $unit = Unit::where('id',$id)->first();
        $current_currency = Currency::where('id',$unit->currency_id)->get();
        $currencies = $this->currencyService->list();

        $data = '{"releases":'.$currencies.'}';
        return $data;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id)
    {
        if(FrontEndHelper::subscriptionlimit() == 'OVER_THRESHHOLD'){
            abort(403);
        }

        $unit = new Unit();
        $unitTypes = UnitType::all();
        $periods = Period::all();
        $floors = Floor::where('property_id',$id)->get();
        $currencies = $this->currencyService->list();
        $basecurrency = $this->currencyService->baseCurrency();
        $unit->currency_id  = $basecurrency->id;
        $unit->propertyid = $id;
        $unit->schedule_id = Period::where('code', 'MONTHLY')->first();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'unitTypes' => $unitTypes,
                'periods' => $periods,
                'floors' => $floors,
                'currencies' => $currencies,
            ]);
        }
        return view('rent.units.create-modal', ['unit' => $unit,'unitTypes'=>$unitTypes,'floors'=>$floors,'periods'=>$periods,'currencies'=>$currencies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitPost $request)
    {

        if(FrontEndHelper::subscriptionlimit() == 'OVER_THRESHHOLD'){
            abort(403);
        }

        try {
            $unit = $this->unitService->create($request);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'unitApi' => $unit,
                ], 201);
            }

            // return redirect()->route('rent.properties.show');

            return response()->json(
                [
                    'message' => 'success',
                    'url' => route('rent.units.unitsonproperty', $request->property_id),
                    'target' => '#units-tab-loader'
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
        if(!Auth::user()->hasAnyDirectPermission(['view_units','list_units'])){
            abort(401);
        }

        $unit = $this->unitService->get($id);
        return view('rent.units.show', ['unit' => $unit]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!Auth::user()->hasDirectPermission(['edit_units'])){
            abort(401);
        }
        $unit = Unit::findorfail($id);
        $unitTypes = UnitType::all();
        $periods = Period::all();
        $floors = Floor::where('property_id',$unit->property_id)->get();
        $currencies = $this->currencyService->list();

        return view('rent.units.edit-modal', ['unit' => $unit,'unitTypes'=>$unitTypes,'floors'=>$floors,'periods'=>$periods,'currencies'=>$currencies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(unitPost $request, string $id)
    {


            try {

                $unit = $this->unitService->update($request,$id);
                Session::flash('success','Unit updated successfully');
                  if(Route::current()->middleware()[0]=="api"){

                return response()->json(
                   [
             "msg"=> "Unit updated successfully"
            ]);
            }
                return redirect()->route('rent.units.show', $unit);
            } catch (Exception $e) {

                Session::flash('error','Oops! something went wrong.');
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        if(!$unit->is_available) throw New Exception('The Unit can not be deleted because it has a tenant unit attached to it');
        $unit->delete();
        if(Route::current()->middleware()[0]=="api"){

                return response()->json(
                   [
             "msg"=> "unit deleted successfully"
            ]);
            }



        return response()->json(
         [
             "msg"=> "unit deleted successfully"
            ]);

    }
}