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
use App\Http\Requests\Rent\PropertyPost;
use App\Models\Rent\Property;
use DB;

class PropertyService implements iPropertyService
{
    public function create(PropertyPost $request)
    {

        DB::beginTransaction();
        try {
            $property = new Property();
            $property->number = $this->nextNumber();
            $property->name = $request->name;
            $property->location = $request->location;
            $property->square_meters = $request->square_meters;
            $property->description = $request->description;
            $property->property_type_id = $request->property_type_id;
            $property->property_category_id = $request->property_category_id;
            $property->created_by = Auth::id();
            $property->save();

            DB::commit();
            return $property;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return Property::with(['propertyType'])->findOrFail($id);
    }

    public function list()
    {
        $properties = Property::with(['propertyType']);
        return $properties->latest()->orderBy('id', 'desc')->get();
    }

    public function nextNumber()
    {
        $date = Carbon::now()->format('ymdHis');
        return 'P-'.$date.'';

    }


    public function update(PropertyPost $request, int $id)
    {

       $property =  Property::with(['propertyType'])->findOrFail($id);

        DB::beginTransaction();
        try {

            $property->name = $request->name;
            $property->location = $request->location;
            $property->square_meters = str_replace(',', '', $request->square_meters);
            $property->description = $request->description;
            $property->property_type_id = $request->property_type_id;
            $property->property_category_id = $request->property_category_id;
            $property->updated_by= Auth::id();
            $property->save();

            DB::commit();
            return $property;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


}
