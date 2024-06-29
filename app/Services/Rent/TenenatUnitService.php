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
use App\Http\Requests\Rent\TenantUnitPost;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\PaymentSchedule;
use App\Models\Rent\Period;
use App\Models\Rent\Ledger;
use App\Models\Rent\Unit;
use App\Services\Accounts\iCurrencyService;
use Illuminate\Support\Facades\Route;

use DB;

class TenenatUnitService implements iTenenatUnitService
{

    protected $currencyService;

    public function __construct(iCurrencyService $currencyService)
    {
    $this->currencyService = $currencyService;
    }

    public function create(TenantUnitPost $request)
    {

        $conversion =  $this->currencyService->convert($request->currency_id, $request->discount_amount);
        $conversion_discountamount =  $this->currencyService->convert($request->currency_id, $request->discount_amount);

        DB::beginTransaction();
        try {
            $tenantunit = new TenantUnit();
            $tenantunit->from_date = isset($request->from_date) ?
            Carbon::createFromFormat('d/m/Y', $request->from_date) : null;
            $tenantunit->to_date = isset($request->to_date) ?
            Carbon::createFromFormat('d/m/Y', $request->to_date) : null;
            $tenantunit->amount = str_replace(',', '', $request->amount);
            $tenantunit->converted_amount = $conversion[0];
            $tenantunit->foreign_amount = $conversion[1];
            $tenantunit->base_amount = $conversion[2];

            $tenantunit->discount_amount = str_replace(',', '', $request->discount_amount);
            $tenantunit->converted_discount_amount = $conversion_discountamount[0];
            $tenantunit->foreign_discount_amount = $conversion_discountamount[1];
            $tenantunit->base_discount_amount = $conversion_discountamount[2];

            $tenantunit->description = $request->description;
            $tenantunit->unit_id  = $request->unit_id;
            $tenantunit->terms  = $request->terms;
            $tenantunit->tenant_id  = $request->tenant_id;
            $tenantunit->duration  = $request->duration;
            $tenantunit->currency_id  = $request->currency_id;
            $tenantunit->schedule_id  = $request->schedule_id;
            $tenantunit->property_id  = $request->property_id;
            $tenantunit->created_by = Auth::id();
            $tenantunit->save();

            $count = $request->duration;
            $period = Period::findOrFail($request->schedule_id);
            $counter = 0;

            $term = str_replace(',', '', $request->terms);

            for ($x = 0; $x < $count; $x++) {

            $increment = $x;

            if($period->code == 'DAILY'){
            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addDays($increment);
            $fromdateConvert = $from->format('Y-m-d');
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addDays($increment);
            $to = $todate;
            $addedterms = $request->terms;
            $projectiontodate = Carbon::createFromFormat('Y-m-d', $fromdateConvert)->addDays($addedterms)->format('Y-m-d');

            } else if($period->code == 'WEEKLY'){

            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addWeeks($increment);
            $fromdateConvert = $from->format('Y-m-d');
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addWeeks($increment);
            $to = $todate->addDays(7);
            $addedterms = $request->terms;
            $projectiontodate = Carbon::createFromFormat('Y-m-d', $fromdateConvert)->addWeeks($addedterms)->format('Y-m-d');

            }  else if($period->code == 'MONTHLY'){
            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addMonths($increment);
            $fromdateConvert = $from->format('Y-m-d');
            $to = Carbon::createFromFormat('Y-m-d', $fromdateConvert)->addMonths(1);
            $addedterms = $request->terms;
            $projectiontodate = Carbon::createFromFormat('Y-m-d', $fromdateConvert)->addMonths($addedterms)->format('Y-m-d');

            }  else if($period->code == 'YEARLY'){

            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addYears($increment);
            $fromdateConvert = $from->format('Y-m-d');
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addYears($increment);
            $to = $todate->addDays($todate->daysInYear);
            $addedterms = $request->terms;
            $projectiontodate = Carbon::createFromFormat('Y-m-d', $fromdateConvert)->addYears($addedterms)->format('Y-m-d');
            }


            $increment = $x;
            $occurance = $increment + 1;

            if($request->terms == 1){
                $termsamount =  str_replace(',', '', $request->discount_amount);
                $convertedtermsamount =  $conversion_discountamount[0];
                $foreigntermsamount =  $conversion_discountamount[1];
                $basetermsamount =  $conversion_discountamount[2];
            } else {
                if(++$counter % $term == 1) {

                    $termsamount =  str_replace(',', '', $request->discount_amount) * $request->terms;
                    $convertedtermsamount =  $conversion_discountamount[0] * $request->terms;
                    $foreigntermsamount =  $conversion_discountamount[1] * $request->terms;
                    $basetermsamount =  $conversion_discountamount[2] * $request->terms;

                    } else {
                        $termsamount =  '0';
                        $convertedtermsamount =  '0';
                        $foreigntermsamount = '0';
                        $basetermsamount =  '0';
                    }
            }

            $paymentschedule = new PaymentSchedule();
            $paymentschedule->from_date = $from;
            $paymentschedule->to_date = $to;
            $paymentschedule->discount_amount = str_replace(',', '', $request->discount_amount);
            $paymentschedule->converted_discount_amount = $conversion_discountamount[0];
            $paymentschedule->foreign_discount_amount = $conversion_discountamount[1];
            $paymentschedule->base_discount_amount = $conversion_discountamount[2];

            $paymentschedule->tenant_id  = $request->tenant_id;
            $paymentschedule->schedule_id  = $request->schedule_id;

            $paymentschedule->paid  = '0';
            $paymentschedule->converted_paid = '0';
            $paymentschedule->foreign_paid = '0';
            $paymentschedule->base_paid = '0';

            $paymentschedule->balance_c_forward  = '0';

            $paymentschedule->balance  = str_replace(',', '', $request->discount_amount);
            $paymentschedule->converted_balance = $conversion_discountamount[0];
            $paymentschedule->foreign_balance = $conversion_discountamount[1];
            $paymentschedule->base_balance = $conversion_discountamount[2];

            $paymentschedule->payment_terms_amount  = $termsamount;
            $paymentschedule->converted_payment_terms_amount = $convertedtermsamount;
            $paymentschedule->foreign_payment_terms_amount = $foreigntermsamount;
            $paymentschedule->base_payment_terms_amount = $basetermsamount;

            $paymentschedule->unit_id  = $request->unit_id;
            $paymentschedule->tenant_unit_id  = $tenantunit->id;
            $paymentschedule->description = $request->description;
            $paymentschedule->created_by = Auth::id();
            $paymentschedule->save();

            $fromldate = Carbon::createFromFormat('Y-m-d', $fromdateConvert)->formatLocalized('%d %b,%y');
            $projectoltodate = Carbon::createFromFormat('Y-m-d', $projectiontodate)->formatLocalized('%d %b,%y');


            }


            $unit = Unit::findOrFail($request->unit_id);
            $unit->is_available = '0';
            $unit->updated_by = Auth::id();
            $unit->save();

            DB::commit();
            return $tenantunit;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return TenantUnit::with(['tenant','unit','period', 'schedules', 'tenant.clientProfiles'])->findOrFail($id);
    }

    public function tenantunitsonproperty(int $id)
    {
        $tenantunits =  TenantUnit::with(['tenant','unit','period', 'schedules', 'tenant.clientProfiles', 'currency'])->where('property_id', $id)->get();
        if(Route::current()->middleware()[0]== "api"){
            foreach($tenantunits as $tenantunit){
            $tenantunit['can_edit'] = $tenantunit->canEditTenantUnit();
            $tenantunit['can_delete'] = $tenantunit->candelete();

            }
        }
        return $tenantunits;
    }

    public function list()
    {
        $properties = TenantUnit::with(['tenantunitType']);
        return $properties->latest()->orderBy('id', 'desc')->get();
    }

    public function nextNumber()
    {
        $date = Carbon::now()->format('ymdHis');
        return 'TU-'.$date.'';

    }


    public function update(tenantunitPost $request, int $id)
    {
        $conversion =  $this->currencyService->convert($request->currency_id, $request->amount);
        $conversion_discountamount =  $this->currencyService->convert($request->currency_id, $request->discount_amount);

        DB::beginTransaction();
        try {
            $tenantunit =  TenantUnit::findOrFail($id);
            $tenantunit->from_date = isset($request->from_date) ?
            Carbon::createFromFormat('d/m/Y', $request->from_date) : null;
            $tenantunit->to_date = isset($request->to_date) ?
            Carbon::createFromFormat('d/m/Y', $request->to_date) : null;
            $tenantunit->amount = str_replace(',', '', $request->amount);
            $tenantunit->converted_amount = $conversion[0];
            $tenantunit->foreign_amount = $conversion[1];
            $tenantunit->base_amount = $conversion[2];

            $tenantunit->discount_amount = str_replace(',', '', $request->discount_amount);
            $tenantunit->converted_discount_amount = $conversion_discountamount[0];
            $tenantunit->foreign_discount_amount = $conversion_discountamount[1];
            $tenantunit->base_discount_amount = $conversion_discountamount[2];

            $tenantunit->description = $request->description;
            $tenantunit->unit_id  = $request->unit_id;
            $tenantunit->tenant_id  = $request->tenant_id;
            $tenantunit->duration  = $request->duration;
            $tenantunit->currency_id  = $request->currency_id;
            $tenantunit->schedule_id  = $request->schedule_id;
            $tenantunit->property_id  = $request->property_id;
            $tenantunit->updated_by= Auth::id();
            $tenantunit->save();

            $tenantunit->schedules()->delete();


            $count = $request->duration;
            $period = Period::findOrFail($request->schedule_id);



            for ($x = 0; $x < $count; $x++) {

            $increment = $x;

            if($period->code == 'DAILY'){
            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addDays($increment);
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addDays($increment);
            $to = $todate;

            } else if($period->code == 'WEEKLY'){

            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addWeeks($increment);
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addWeeks($increment);
            $to = $todate->addDays(7);

            }  else if($period->code == 'MONTHLY'){
            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addMonths($increment);
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addMonths($increment);
            $to = $todate->addDays($todate->daysInMonth);


            }  else if($period->code == 'YEARLY'){

            $from = Carbon::createFromFormat('d/m/Y', $request->from_date)->addYears($increment);
            $todate = Carbon::createFromFormat('d/m/Y', $request->from_date)->addYears($increment);
            $to = $todate->addDays($todate->daysInYear);
            }

            $paymentschedule = new PaymentSchedule();
            $paymentschedule->from_date = $from;
            $paymentschedule->to_date = $to;
            $paymentschedule->discount_amount = str_replace(',', '', $request->discount_amount);
            $paymentschedule->converted_discount_amount = $conversion_discountamount[0];
            $paymentschedule->foreign_discount_amount = $conversion_discountamount[1];
            $paymentschedule->base_discount_amount = $conversion_discountamount[2];

            $paymentschedule->tenant_id  = $request->tenant_id;
            $paymentschedule->schedule_id  = $request->schedule_id;

            $paymentschedule->paid  = '0';
            $paymentschedule->converted_paid = '0';
            $paymentschedule->foreign_paid = '0';
            $paymentschedule->base_paid = '0';

            $paymentschedule->balance_c_forward  = '0';

            $paymentschedule->balance  = str_replace(',', '', $request->discount_amount);
            $paymentschedule->converted_balance = $conversion_discountamount[0];
            $paymentschedule->foreign_balance = $conversion_discountamount[1];
            $paymentschedule->base_balance = $conversion_discountamount[2];

            $paymentschedule->unit_id  = $request->unit_id;
            $paymentschedule->tenant_unit_id  = $tenantunit->id;
            $paymentschedule->description = $request->description;
            $paymentschedule->created_by = Auth::id();
            $paymentschedule->save();

            }

            $unit = Unit::findOrFail($request->unit_id);
            $unit->is_available = '0';
            $unit->updated_by = Auth::id();
            $unit->save();

            DB::commit();
            return $tenantunit;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function delete(int $id)
    {
        $tenanunit = TenantUnit::findorfail($id);
        $tenanunit->schedules()->delete();

        $unit = Unit::where('id',$tenanunit->unit_id)->first();
        $unit->is_available = 1;
        $unit->save();

        $tenanunit->delete();
        DB::beginTransaction();

        try {

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }




}