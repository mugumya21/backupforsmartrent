<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\Setting;
use App\Models\Accounts\Currency;
use App\Services\Admin\iSettingService;
use App\Helpers\FrontEndHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $settingService;
     public function __construct(iSettingService $settingService)
     {
         $this->settingService = $settingService;
     }

    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function subscription()
    {
        $setting = new Setting();

        return view('admin.settings.create-modal-subscription', ['setting' => $setting]);
    }


    public function subscriptionSubmit(Request $request)
    {
        try {

            $setting = $this->settingService->subscriptionSubmit($request);

            return response()->json(
                [
                    'message' => 'The action was successfull',
                    'url' => '',
                    'target' => ''
                ], 200);

        } catch (Exception $e) {
            // return some other error, or rethrow as above.
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'text' => ''
                ], 400);
        }
    }




    public function basecurrency()
    {
        $setting = new Setting();
        $currencies = Currency::all();
        $setting->currency_id = FrontEndHelper::baseCurrency()->id;
        $currency = Setting::where('key', 'Base_Currency')->first();
        $setting->currency_id = Currency::where('code',$currency->value)->first();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                $currencies,
            );
        }
        return view('admin.settings.create-modal-basecurrency', ['setting' => $setting,'currencies'=>$currencies]);
    }


    public function basecurrencysubmit(Request $request)
    {

            try {
                $setting = $this->settingService->basecurrencysubmit($request);

                if(Route::current()->middleware()[0]=="api"){

                    return response()->json(
                        $setting,
                    201);
                }

                return response()->json(
                    [
                        'message' => 'The action was successful',
                        'url' => '',
                        'target' => ''
                    ], 200);

            } catch (Exception $e) {
                // return some other error, or rethrow as above.
                return response()->json(
                    [
                        'message' => $e->getMessage(),
                        'text' => ''
                    ], 400);
            }

    }



    
    public function foreigncurrency()
    {
        $setting = new Setting();
        $currencies = Currency::all();
        $setting->currency_id = FrontEndHelper::baseCurrency()->id;
        $currency = Setting::where('key', 'Foreign_Currency')->first();
        if(!empty($currency)){
            $setting->currency_id = Currency::where('code',$currency->value)->first();
        } else {
            $setting->currency_id = 0;
        }
        if(Route::current()->middleware()[0]=="api"){

            return response()->json(
                $currencies,
            );
        }
        return view('admin.settings.create-modal-foreigncurrency', ['setting' => $setting,'currencies'=>$currencies]);
    }


    public function foreigncurrencysubmit(Request $request)
    {

            try {
                $setting = $this->settingService->foreigncurrencysubmit($request);

                if(Route::current()->middleware()[0]=="api"){

                    return response()->json(
                        $setting,
                    201);
                }

                return response()->json(
                    [
                        'message' => 'The action was successful',
                        'url' => '',
                        'target' => ''
                    ], 200);

            } catch (Exception $e) {
                // return some other error, or rethrow as above.
                return response()->json(
                    [
                        'message' => $e->getMessage(),
                        'text' => ''
                    ], 400);
            }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
