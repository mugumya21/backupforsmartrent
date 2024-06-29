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
use App\Models\Rent\PaymentSchedule;
use DB;

class PaymentScheduleService implements iPaymentScheduleService
{
    public function create()
    {
       
    }

    public function get(int $id)
    {
      
    }

    public function list(int $id)
    {
        $paymentschedule = PaymentSchedule::with(['tenantunit'])->where('tenant_unit_id',$id);
        return $paymentschedule->latest()->orderBy('from_date', 'asc')->get();
    }



}
