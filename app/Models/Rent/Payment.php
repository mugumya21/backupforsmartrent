<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rent\TenantUnit;
use App\Models\Rent\PaymentItem;
use App\Models\Accounts\PaymentMode;
use Carbon\Carbon;
use Rmunate\Utilities\SpellNumber;
use App\Models\System\Setting;
use App\Models\Accounts\Currency;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
use App\Models\Accounts\Account;
use Illuminate\Support\Facades\Auth;


class Payment extends Model
{
    use HasFactory;

    protected $dates = [
        'date',
    ];
    public function candelete()
    {
        if(Auth::user()->hasDirectPermission('delete_payments')){
            return true;
        }
        else{
            return false;
        }
    }
    public function amountDisp()
    {
        return number_format($this->amount, 0);
    }

    public function date()
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)->format('d/m/Y');
    }

    public function amountpaidWords()
    {
    $converted =  SpellNumber::value($this->amountpaid())->locale('en')->toLetters();
    $baseCurrency =   Setting::where('key','Base_Currency')->first();
    $currency = Currency::where('code',$baseCurrency->value)->first();

    return ''.$this->tenantunit->currency->code.' '.$converted.'';

    }


    public function balanceDisp()
    {
        return number_format($this->balance(), 0);
    }

    public function balance()
    {

        $total = $this->amountdue() - $this->amountpaid();

        return $total;
    }

    public function amountdueDisp()
    {
        return number_format($this->amountdue(), 0);
    }

    public function amountdue()
    {
        return $this->amount_due;

    }

    public function amountpaidDisp()
    {
        return number_format($this->amountpaid(), 0);
    }

    public function amountpaid()
    {
        return $this->amount;

    }

    public function foreigncurrency()
    {
       $foreigncurrency = Setting::where('key','Foreign_Currency')->first();
       return $foreigncurrency;
    }

    public function reportamountpaid(int $id)
    {
        $currency = Currency::where('id',$id)->first();
        if($currency->code == $this->foreigncurrency()->value){
        return $this->foreign_amount;
        } else {
        return $this->base_amount;
        }
    }

    public function reportamountpaidDisp()
    {
    return number_format($this->reportamountpaid(), 0);
    }


    public function documents()
    {
      $type =   DocumentType::where('code','PAYMENTS')->first();
      $documents =   Document::where('external_key', $this->id)->where('document_type_id', $type->id)->get();
      return $documents;
    }


    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function paymentmode()
    {
        return $this->belongsTo(PaymentMode::class,'payment_mode_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }

    public function tenantunit()
    {
        return $this->belongsTo(TenantUnit::class,'tenant_unit_id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class,'account_id');
    }

}
