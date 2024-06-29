<?php

namespace App\Http\Controllers\rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent\Property;
use App\Models\Rent\PropertyType;
use App\Models\Rent\PropertyCategory;
use App\Services\Rent\iPropertyService;
use App\Services\Accounts\iCurrencyService;
use App\Http\Requests\Rent\PropertyPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\CRM\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\Main\Document;
use App\Helpers\FrontEndHelper;
use App\Models\Main\DocumentType;
use Illuminate\Support\Facades\Route;
use App\Models\Rent\Unit;
use App\Models\Accounts\Currency;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $propertyService;

     public function __construct(iPropertyService $propertyService,iCurrencyService $currencyService)
     {
         $this->propertyService = $propertyService;
         $this->currencyService = $currencyService;
     }



     public function index()
     {
         $properties = $this->propertyService->list();
         $filetype = DocumentType::where('code', 'PTD')->first();
         $filetype = $filetype->id;

         if (Route::current()->middleware()[0] == "api") {
             $propertyDetails = [];

             foreach ($properties as $property) {
                 $unit_schedule = null;
                 $lowestUnitAmount = null;
                 $unitName = null;
                $basecurrency = $this->currencyService->baseCurrency();

                 $app_url = url('/');
                 $featuredImageTempKey = $property->featuredImage()->temp_key ?? null;
                 if ($featuredImageTempKey !== null) {
                     $app_url = $app_url . '/uploads/documents/' . $property->featuredImage()->temp_key;
                 } else {
                     $app_url = '';
                 }

            // $lowestUnit = $property->units()->orderBy('converted_amount', 'ASC')->first();
            // if ($lowestUnit) {
            // $lowestUnitAmount = $lowestUnit->converted_amount;
            // $unitName = $lowestUnit->name;
            // $unit_schedule = $lowestUnit->period->name;
            // $currencyName = $lowestUnit->currency->code;
            // }

                     $propertyDetails[] = [
                         'id' => $property->id,
                         'name' => $property->name,
                         'number' => $property->number,
                         'location' => $property->location,
                         'square_meters' => $property->square_meters,
                         'description' => $property->description,
                         'property_type_id' => $property->property_type_id,
                         'property_category_id' => $property->property_category_id,
                         'created_by' => $property->created_by,
                         'updated_by' => $property->updated_by,
                         'created_at' => $property->created_at,
                         'updated_at' => $property->updated_at,
                         'property_type' => $property->propertyType,
                         'category' => $property->category,
                         'total_units' => $property->totalunits(),
                         'occupied_units' => $property->occupiedunits()->count(),
                         'available_units' => $property->availableunits()->count(),
                         'unit_amount' => $lowestUnitAmount,
                         'unit_schedule' => $unit_schedule,
                         'filetype' => $filetype,
                         'image_url' => $app_url,
                         'can_edit' => $property->canedit(),
                         'can_delete' => $property->candelete(),
                        //  'currency_name' => $basecurrency->code,
                        //  'unit_name' => $unitName,
                     ];

             }
             return response()->json(['properties' => $propertyDetails], 200);
         }
         return view('rent.properties.index', ['properties' => $properties]);
     }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $property = new Property();
        $types = PropertyType::all();
        $categories = PropertyCategory::all();
        if(Route::current()->middleware()[0]=="api")
        {

            return response()->json([
                "types"=>$types,
                "categories"=>$categories,

            ]

           );
        }

        return view('rent.properties.create', ['property' => $property,'categories'=>$categories,'types'=>$types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyPost $request)
    {
        try {

            $property = $this->propertyService->create($request);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'propertyCreatedViaApi' => $property,
                ], 201);
            }
            Session::flash('success','Awesome! that was successful');
            return redirect()->route('rent.properties.show', $property);
        } catch (Exception $e) {
            Log::debug($e);
            Session::flash('error','Oops! something went wrong.');
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }


    public function profilepic($id)
    {

        $property = $this->propertyService->get($id);
        $profilepic = $property->featuredImage();

        return view('rent.properties.profilepic', ['profilepic' => $profilepic]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $property = $this->propertyService->get($id);


        $tenantids = $property->tenantunits->pluck('tenant_id');
        $tenants =  Client::whereIn('id',$tenantids)->get();

        $tenants = $tenants->map(function($tenant) use ($property){


          $tenantarrears =   $tenant->tenantunits()->WhereHas('schedules', function ($query) use ($tenant) {
                $date = Carbon::now()->subdays(1);
                $query->where('from_date','<',$date)->where('balance','>',0);

            }
        );

            $tenant['count'] =  $tenantarrears->count();
            return $tenant;

        });

        $tenants = $tenants;

        $filetype = DocumentType::where('code','PTD')->first();
        $filetype = $filetype->id;

        if(Route::current()->middleware()[0]=="api") {

            return response()->json([

                $property,
                $filetype,
            ]


            );
        }
        return view('rent.properties.show', ['property' => $property,'tenants'=>$tenants,'filetype'=>$filetype,'docid'=>$property->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $property = $this->propertyService->get($id);
        $types = PropertyType::all();
        $categories = PropertyCategory::all();

        return view('rent.properties.edit', ['property' => $property,'categories'=>$categories,'types'=>$types]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(PropertyPost $request, string $id)
    {
        try {

            $property = $this->propertyService->update($request, $id);
            if(Route::current()->middleware()[0]=="api") {

                return response()->json(

                    $property

                );
            }
            Session::flash('success','Awesome! that was successful');
            return redirect()->route('rent.properties.show', $property);
        } catch (Exception $e) {
            Log::debug($e);
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }


    public function getpropertydetails(int $id)
    {
        $units = Unit::where('property_id',$id)->get();

        $data = '{"releases":'.$units.'}';
        return $data;

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}