<?php


namespace App\Services\Accounts;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\Accounts\CurrencyRatePost;
use App\Http\Requests\Accounts\CurrencyRateSearchPost;
use App\Http\Requests\Accounts\ForexExchangePost;
use App\Models\Accounts\CurrencyRate;
use Auth;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class CurrencyRateService implements iCurrencyRateService
{

    public function list()
    {
        return CurrencyRate::with('currency')->get();
    }

    public function create(CurrencyRatePost $request)
    {
        $currencyRate = new CurrencyRate();

        $currencyRate->date = $request->date;
        $currencyRate->buying = str_replace(',', '', $request->buying);
        $currencyRate->selling = str_replace(',', '', $request->selling);
        $currencyRate->currency_id = $request->currency_id;
        $currencyRate->created_by = Auth::id();

        DB::beginTransaction();
        try {
            $currencyRate->save();
            DB::commit();
            return $currencyRate;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return CurrencyRate::with('currency')->find($id);
    }

    public function update(CurrencyRatePost $request, int $id)
    {
        $currencyRate = CurrencyRate::find($id);
        //$currencyRate->date = $request->date;
        $currencyRate->buying = $request->buying;
        $currencyRate->selling = $request->selling;
        $currencyRate->currency_id = $request->currency_id;
        $currencyRate->updated_by = Auth::id();

        DB::beginTransaction();
        try {
            $currencyRate->save();
            DB::commit();
            return $currencyRate;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function ForexExchange(ForexExchangePost $request)
    {
        $currencyRate = CurrencyRate::with('currency')
            ->where('date', $request->date->toDateString())
            ->where('currency_id', $request->currency_id)
            ->firstOrFail();

        return $request->amount * $currencyRate->buying;
    }

    public function GetRatesByDate(Request $request)
    {
        $rates = CurrencyRate::with('currency')
            ->where('date', $request->date->toDateString());

        if ($request->currency_id) {
            $rates = $rates->where('currency_id', $request->currency_id);
        }

        return $rates->latest()->orderBy('id','desc')->get();
    }

    public function GetCurrencyRateByDate(Request $request)
    {
        return $rates = CurrencyRate::with('currency')
            ->where('date', $request->date->toDateString())
            ->where('currency_id', $request->currency_id)
            ->first();
    }
}