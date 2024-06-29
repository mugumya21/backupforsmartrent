<?php

namespace App\Http\Controllers\rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Rent\FloorPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Services\Rent\iFloorsService;
use App\Models\Rent\Floor;
use App\Models\Rent\Property;
use Illuminate\Support\Facades\Route;

class FloorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $floorsService;

     public function __construct(iFloorsService $floorsService)
     {
         $this->floorsService = $floorsService;
     }




    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

     public function floorsonproperty($id)
     {
         $floors = $this->floorsService->floorsonproperty($id);
         if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'floorsonproperty' => $floors,
            ], 201);
        }
         return view('rent.floors.floors-on-property', ['floors' => $floors]);
     }



    public function create(int $id)
    {
        $floor = new Floor();
        $floor->propertyid = $id;

        return view('rent.floors.create-modal', ['floor' => $floor]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FloorPost $request)
    {
        try {
            $floor = $this->floorsService->create($request);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'floorCreatedViaApi' => $floor,
                ], 201);
            }
            return response()->json(
                [
                    'message' => 'success',
                    'url' => route('rent.floors.floorsonproperty', $request->property_id),
                    'target' => '#floor-tab-loader'
                ], 200);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return response()->json(
                [
                    'errors' => [$e->getMessage()],
                    'url' => route('rent.properties.show', $request->property_id),
                ], 400);
        }
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
