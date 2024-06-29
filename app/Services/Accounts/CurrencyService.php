<?php


namespace App\Services\Accounts;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\System\Setting;
use App\Models\Accounts\Currency;
use App\Models\Accounts\CurrencyRate;

class CurrencyService implements iCurrencyService
{

    public function convert(int $currency_id, $amount)
    {

        $currency_id = $currency_id;
        $currency = Currency::where('id',$currency_id)->first();
        $code = $currency->code;

        $baseCurrency =   Setting::where('key','Base_Currency')->first();

        if($currency->code == $baseCurrency->value){
        $convertedamount =  str_replace(',', '', $amount);
        }else{

        $date_createdat =   Carbon::now()->format('Y-m-d');
        $rateValue =   CurrencyRate::where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',$date_createdat)->where('currency_id',$currency_id)->first();

        if (!empty($rateValue)) {
            $rate = $rateValue->buying;
        } else {

            if ($code == 'USD') {
                $rate = 3885.90;
            } else if ($code == 'UGX') {
                $rate = 0.00026;
            }
        }

        $convertedamount = str_replace(',', '', $amount) * $rate;
        
    }

    if($code == 'UGX'){
        $ugxamount = str_replace(',', '', $amount);
        $usdamount = str_replace(',', '', $amount) * 0.00026;
    } else if($code == 'USD'){
        $ugxamount = str_replace(',', '', $amount) * 3885.90;
        $usdamount = str_replace(',', '', $amount);
    }

    return array($convertedamount, $usdamount, $ugxamount);


}


public function baseCurrency()
{
    $setting = Setting::where('key','Base_Currency')->first();
    $currency = Currency::where('code',$setting->value)->first();
    return $currency;
}

public function list()
{
     return Currency::where('code','USD')->orwhere('code','UGX')->get();
}

}