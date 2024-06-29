<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Client;
use App\Models\Accounts\Currency;
use App\Models\System\Setting;
use Carbon\Carbon;
use App\Models\Rent\TenantUnit;

class PaymentSchedule extends Model
{
    use HasFactory;

    protected $dates = ['from_date','to_date'];

    public function fromDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->from_date)->format('d/m/Y');

    }

    public function shortFromDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->from_date)->formatLocalized('%d %b, %y');

    }

    public function shortToDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->to_date)->formatLocalized('%d %b, %y');
    }


    public function toDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->to_date)->format('d/m/Y');
    }


    public function toDateProjection()
    {
        $term = $this->tenantunit->terms;

        if($this->tenantunit->terms == 1){
            return  $this->shortToDate();
            } else {
                $todate = Carbon::createFromFormat('Y-m-d', $this->from_date)->addMonths($term);
                return  $todate->formatLocalized('%d %b, %y');
            }

    }

    public function foreigncurrency()
    {
       $foreigncurrency = Setting::where('key','Foreign_Currency')->first();
       return $foreigncurrency;
    }

    public function amountDisp()
    {
        return number_format($this->discount_amount, 0);
    }


    public function reportamountDisp(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return number_format($this->foreign_discount_amount, 0);
        } else {
        return number_format($this->base_discount_amount, 0);
        }
    }


    public function paymentstatus()
    {
    if($this->paymentitems->count() >0){
    return 'Rent Payment';
        } else {
            return 'Rent Charge';
        }
    }


    public function debit()
    {
        if($this->paymentitems->count() >0){
            return '0';
                } else {
                    return $this->expectedamount();
                }
    }


    public function credit()
    {
        if($this->paymentitems->count() >0){
            return $this->expectedamount();
                } else {
                    return '0';
                }
    }

    public function ledgerbalance()
    {
        if($this->paymentitems->count() >0){
            return '0';
                } else {
                    return $this->debit() - $this->credit();
                }
    }

    public function reportamount(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return $this->foreign_discount_amount;
        } else {
        return $this->base_discount_amount;
        }
    }



    public function expectedamountDisp()
    {
        return number_format($this->payment_terms_amount, 0);
    }

    public function expectedamount()
    {
        return $this->payment_terms_amount;
    }


    public function paidamountDisp()
    {
        return number_format($this->paid, 0);
    }

    public function reportpaidamountDisp(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return number_format($this->foreign_paid, 0);
        } else {
        return number_format($this->base_paid, 0);
        }
    }

    public function reportpaidamount(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return $this->foreign_paid;
        } else {
        return $this->base_paid;
        }
    }


    // public function paymentonschedulestatus()
    // {
    //     if($this->paymentitems->count() >0){

    //             } else {


    //         }
    // }


    public function reportbalanceDisp(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return number_format($this->foreign_balance, 0);
        } else {
        return number_format($this->base_balance, 0);
        }
    }

    public function reportbalance(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return $this->foreign_balance;
        } else {
        return $this->base_balance;
        }
    }

    public function balanceDisp()
    {
        return number_format($this->balance, 0);
    }


    public function lastSchedule()
    {
        return PaymentSchedule::where('id', '<', $this->id)->max('id');
    }


    public function nextSchedule()
    {
        return PaymentSchedule::where('id', '>', $this->id)->min('id');

    }

    public function client()
    {
        return $this->belongsTo(Client::class,'tenant_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class,'schedule_id');
    }

    public function Unit()
    {
        return $this->belongsTo(Unit::class);
    }


    public function tenantunit()
    {
        return $this->belongsTo(TenantUnit::class, 'tenant_unit_id');
    }

    public function paymentitems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
