<?php

namespace App\Services\Admin;

use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\System\Setting;
use App\Models\Accounts\Currency;

class SettingService implements iSettingService
{
   

    /**
     * UserService constructor.
     */
    public function __construct()
    {
    }

    public function basecurrencysubmit(Request $request)
    {
        DB::beginTransaction();
        try {

            $currency = Currency::where('id',$request->currency_id)->first();

            $setcurrency = Setting::where('key', 'Base_Currency')->first();

            $setting =  Setting::findorfail($setcurrency->id);
            $setting->value = $currency->code;
            $setting->description = $request->description;
            $setting->updated_by = Auth::id();
            $setting->save();

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function foreigncurrencysubmit(Request $request)
    {
        DB::beginTransaction();
        try {

            $currency = Currency::where('id',$request->currency_id)->first();
            $setcurrency = Setting::where('key', 'Foreign_Currency')->first();
            if(!empty($setcurrency)){
            $setting =  Setting::findorfail($setcurrency->id);
            $setting->updated_by = Auth::id();
            } else {
            $setting =  new Setting();
            $setting->key = 'Foreign_Currency';
            $setting->created_by = Auth::id();
            }

            $setting->value = $currency->code;
            $setting->description = $request->description;
          
            $setting->save();

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function subscriptionSubmit(Request $request)
    {
        DB::beginTransaction();
        try {


            $setting = Setting::where('key', 'SUBSCRIBE_UNITS_VALUE')->first();

            if(!empty($setting)){

                $setting =  Setting::findorfail($setting->id);
                $setting->value = str_replace(',', '', $request->value); 
                $setting->updated_by = Auth::id();
                
            } else {
                $setting = new Setting();
                $setting->key = 'SUBSCRIBE_UNITS_VALUE';
                $setting->value =  str_replace(',', '', $request->value); 
                $setting->created_by = Auth::id();
            }

            $setting->save();

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


}
