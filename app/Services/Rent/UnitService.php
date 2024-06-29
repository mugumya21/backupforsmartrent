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
use App\Http\Requests\Rent\UnitPost;
use App\Models\Rent\Unit;
use DB;
use App\Services\Accounts\iCurrencyService;
use Illuminate\Support\Facades\Route;

class UnitService implements iUnitService
{
    protected $currencyService;

    public function __construct(iCurrencyService $currencyService)
    {
    $this->currencyService = $currencyService;
    }

    public function create(UnitPost $request)
    {

        $conversion =  $this->currencyService->convert($request->currency_id, $request->amount);

        DB::beginTransaction();
        try {
            $unit = new Unit();
            $unit->name = $request->name;
            $unit->amount =  str_replace(',', '', $request->amount);
            $unit->converted_amount = $conversion[0];
            $unit->foreign_amount = $conversion[1];
            $unit->base_amount = $conversion[2];
            $unit->floor_id = $request->floor_id;
            $unit->schedule_id = $request->schedule_id ;
            $unit->property_id = $request->property_id;
            $unit->currency_id = $request->currency_id;
            $unit->square_meters = str_replace(',', '', $request->square_meters);
            $unit->unit_type = $request->unit_type;
            $unit->description = $request->description;
            $unit->created_by = Auth::id();
            $unit->save();

            DB::commit();
            return $unit;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return Unit::with(['unitType'])->findOrFail($id);
    }

    public function unitsonproperty(int $id)
    {
        $units =  Unit::with(['floor', 'currency', 'unitType', 'period'])->where('property_id', $id)->orderBy('is_available', 'desc')->latest()->get();
        if(Route::current()->middleware()[0]== "api"){
            foreach($units as $unit){
            $unit['can_edit'] = $unit->canedit();
            $unit['can_delete'] = $unit->candelete();

            }
        }
        return $units;
    }

    public function list()
    {
        $properties = unit::with(['unitType']);
        return $properties->latest()->orderBy('id', 'desc')->get();
    }

    public function nextNumber()
    {
        $date = Carbon::now()->format('ymdHis');
        return 'P-'.$date.'';

    }

    public function update(unitPost $request, int $id)
    {
       $unit =  unit::findOrFail($id);
       $conversion =  $this->currencyService->convert($request->currency_id, $request->amount);

        DB::beginTransaction();
        try {
            $unit->name = $request->name;
            $unit->amount =  str_replace(',', '', $request->amount);
            $unit->converted_amount = $conversion[0];
            $unit->foreign_amount = $conversion[1];
            $unit->base_amount = $conversion[2];
            $unit->floor_id = $request->floor_id;
            $unit->schedule_id = $request->schedule_id ;
            $unit->property_id = $request->property_id;
            $unit->currency_id = $request->currency_id;
            $unit->square_meters = str_replace(',', '', $request->square_meters);
            $unit->unit_type = $request->unit_type;
            $unit->description = $request->description;
            $unit->updated_by= Auth::id();
            $unit->save();

            DB::commit();
            return $unit;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


}
