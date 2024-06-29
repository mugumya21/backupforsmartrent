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
use App\Http\Requests\Rent\FloorPost;
use App\Models\Rent\Floor;
use DB;

class FloorsService implements iFloorsService
{
    public function create(FloorPost $request)
    {
       
        DB::beginTransaction();
        try {
            $floor = new Floor();
            $floor->name = $request->name;
            $floor->property_id = $request->property_id;
            $floor->description = $request->description;
            $floor->created_by = Auth::id();
            $floor->save();

            DB::commit();
            return $floor;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }  
    }

    public function get(int $id)
    {
        return nit::with(['floorType'])->findOrFail($id);
    }

    public function floorsonproperty(int $id)
    {
        $floors =  Floor::where('property_id', $id)->get();
        return $floors;
    }

    public function list()
    {
        $properties = floor::with(['floorType']);
        return $properties->latest()->orderBy('id', 'desc')->get();
    }

    public function nextNumber()
    {
        $date = Carbon::now()->format('ymdHis');
        return 'P-'.$date.'';

    }

    public function update(floorPost $request, int $id)
    {
       $floor =  floor::with(['floorType'])->findOrFail($id);

        DB::beginTransaction();
        try {
         
            $floor->name = $request->name;
            $floor->location = $request->location;
            $floor->square_meters = $request->square_meters;
            $floor->description = $request->description;
            $floor->floor_type_id = $request->floor_type_id;
            $floor->floor_category_id = $request->floor_category_id;
            $floor->updated_by= Auth::id();
            $floor->save();

            DB::commit();
            return $floor;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }  
    }


}
