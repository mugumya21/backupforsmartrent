<?php

namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts\Currency;
use App\Models\System\Setting;
use App\Models\Rent\Unit;

class FrontEndHelper
{
    static function iconUrl(string $icon): string
    {
        switch ($icon) {
            case 'pdf':
                return 'assets/img/file_icons/pdf.svg';
            case 'xls':
            case 'xlsx':
                return 'assets/img/file_icons/xls.svg';
            case 'doc':
            case 'docx':
                return 'assets/img/file_icons/doc.svg';
            case 'csv':
                return 'assets/img/file_icons/csv.svg';
            case 'png':
                return 'assets/img/file_icons/png.svg';
            case 'jpg':
                return 'assets/img/file_icons/jpg.svg';
            default:
                return 'assets/img/file_icons/file.svg';
        }
    }


    static function baseCurrency()
    {
        $setting = Setting::where('key','Base_Currency')->first();
        $currency = Currency::where('code',$setting->value)->first();
        return $currency;
    }

    static function subscriptionlimit()
    {
        $setting = Setting::where('key','SUBSCRIBE_UNITS_VALUE')->first();
        $value = $setting->value;
        $units = Unit::all();
        $unitscount = $units->count();

        if($unitscount >= $value){
            return 'OVER_THRESHHOLD';
        } else {
            return 'UNDER_THRESHHOLD';
        }

    }


}
