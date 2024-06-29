<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 09/04/2018
 * Time: 22:13
 */

namespace App\Services\Accounts;

use Illuminate\Http\Request;
use App\Http\Requests\Accounts\CurrencyRatePost;
use App\Http\Requests\Accounts\CurrencyRateSearchPost;
use App\Http\Requests\Accounts\ForexExchangePost;

interface iCurrencyRateService
{
    public function create(CurrencyRatePost $request);
    public function get(int $id);
    public function update(CurrencyRatePost $request, int $id);
    public function list();

    public function ForexExchange(ForexExchangePost $request);

    public function GetRatesByDate(Request $request);
    public function GetCurrencyRateByDate(Request $request);
}