<?php

namespace App\Http\Controllers\Accounts;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\Currency;
use App\Models\Accounts\CurrencyRate;
use App\Services\Accounts\iCurrencyRateService;
use App\Http\Requests\Accounts\CurrencyRatePost;




class CurrencyRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
    protected $currencyRateService;

    public function __construct(iCurrencyRateService $currencyRateService)
    {
        $this->currencyRateService = $currencyRateService;
    }

    public function index()
    {
        $currencyrates = CurrencyRate::all();

        if (request()->ajax()) {
            $response = view('accounts.rates.rates_table', ['currencyrates' => $currencyrates])->render();
            return $response;
        }
        else {
            return view('accounts.rates.index', ['currencyrates' => $currencyrates]);
        }


        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencyrate = new CurrencyRate();
        $currencies = Currency::where('is_active', 1)->get();
        $currencyrate->date = Carbon::now()->format('Y-m-d');

        return view('accounts.rates.create-modal', ['currencyrate' => $currencyrate, 'currencies' => $currencies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRatePost $request)
    {
        try {

            $currencyRate = $this->currencyRateService->create($request);

            return response()->json(
                [
                    'message' => 'Currency rate successfully added',
                    'url' => route('accounts.rates.index'),
                    'target' => '#reload-container-currency-rates'
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
