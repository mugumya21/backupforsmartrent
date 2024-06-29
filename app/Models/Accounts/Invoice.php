<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounts\InvoiceType;
use App\Models\Rent\Unit;
use App\Models\User;
use App\Models\HR\Employee;
use App\Models\Accounts\Currency;
use App\Models\Accounts\Tax;
use App\Models\Accounts\Account;
use App\Models\Rent\Payment;
use App\Models\Accounts\InvoiceItem;
use App\Models\Accounts\InvoiceStatus;
use App\Models\Rent\Property;
use App\Models\Rent\TenantUnit;
use App\Models\CRM\Client;
use Carbon\Carbon;
use Rmunate\Utilities\SpellNumber;
use App\Models\System\Setting;

class Invoice extends Model
{
    use HasFactory;


    public function amountDisp()
    {
        return number_format($this->amount, 0);
    }

    
    public function balanceDisp()
    {
        return number_format($this->balance, 0);
    }

    public function totalDisp()
    {
        return number_format($this->total(), 0);
    }

    public function total()
    {
     return ($this->tax->rate /100 *  $this->amount) + $this->amount;
    }

    public function totalTax()
    {
     return ($this->tax->rate /100 *  $this->amount);
    }

    public function totalTaxDisp()
    {
        return number_format($this->totalTax(), 0);
    }


    public function canApprove()
    {
        if($this->invoiceStatus->code == 'SUBMITTED' || $this->invoiceStatus->code == 'EDITED'){
            return true;
        }
    }

    public function totalBalanceOnItems()
    {
        $total = $this->items->reduce(function ($carry, $item) {
           
                return $carry + $item->schedule->balance;
            
        });

        return $total;
    }


    public function date()
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)->formatLocalized('%d %b,%y');
    
    }

    public function dueDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->due_date)->formatLocalized('%d %b, %y'); 
    }

    public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
    {
       $name = ''.$this->tenant->clientname().' - ' .($this->unit->name).'';
       return $name;
    }

    public function invoiceActions()
    {
        return $this->hasMany(InvoiceAction::class,'invoice_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Client::class,'tenant_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class,'tax_id');
    }

    public function invoiceStatus()
    {
        return $this->belongsTo(InvoiceStatus::class,'invoice_status_id');
    }

    public function invoiceStatusDisp()
    {
        if ($this->invoiceStatus->code == 'APPROVED') {
            return "  <span class='badge rounded-pill badge-soft-success'>APPROVED</span>";
        } else if ($this->invoiceStatus->code == 'REJECTED') {
            return "<span class='badge rounded-pill badge-soft-danger'>REJECTED</span>";
        } else if ($this->invoiceStatus->code == 'RETURNED') {
            return "<span class='badge rounded-pill badge-soft-warning'>RETURNED</span>";
        } else if ($this->invoiceStatus->code == 'SUBMITTED') {
            return " <span class='badge rounded-pill badge-soft-secondary'>SUBMITTED</span>";
        } else if ($this->invoiceStatus->code == 'EDITED') {
            return "<span class='badge rounded-pill badge-soft-info'>EDITED</span>";
        }
    }

    public function amountpaidWords()
    {
    $converted =  SpellNumber::value($this->total())->locale('en')->toLetters();
    $baseCurrency =   Setting::where('key','Base_Currency')->first();
    $currency = Currency::where('code',$baseCurrency->value)->first();

    return ''.$currency->name.' '.$converted.'';

    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function tenantunit()
    {
        return $this->belongsTo(TenantUnit::class,'tenant_unit_id');
    }

    public function invoiceType()
    {
    return $this->belongsTo(InvoiceType::class,'invoice_type_id');
    }

    public function doneBy()
    {
        return $this->belongsTo(Employee::class, 'done_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'tenant_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function supervisedBy()
    {
        return $this->belongsTo(Employee::class, 'supervisor');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'invoice_id');
    }

}





