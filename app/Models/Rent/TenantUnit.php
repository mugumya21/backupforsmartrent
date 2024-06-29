<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Client;
use Carbon\Carbon;
use App\Models\Accounts\Currency;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
use Illuminate\Support\Facades\Auth;

class TenantUnit extends Model
{
    use HasFactory;

    protected $dates = ['from_date','to_date'];

    public function amountDisp()
    {
        return number_format($this->discount_amount, 0);
    }

    public function discountamountDisp()
    {
        return number_format($this->discount_amount, 0);
    }

    public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
    {
       $name = ''.$this->tenant->clientname().' - ' .($this->unit->name).'';
       return $name;
    }

    public function arrearsdates()
    {
        $date = Carbon::now()->subdays(1);
        return $this->schedules->where('balance', '>',0)->where('from_date','<',$date);
    }

    public function arrearsbalance()
    {
        $date = Carbon::now()->subdays(1);
        $total = $this->schedules->where('from_date','<',$date)->where('balance','>', 0)->reduce(function ($carry, $item) {

                return $carry + $item->balance;

        });

        return $total;
    }

    public function documenttype()
    {
      $type =   DocumentType::where('code','TUND')->first();
      return $type;
    }

    public function expirydays()
    {
        $curentdate = Carbon::now();
        $to = Carbon::createFromFormat('Y-m-d', $this->to_date);
        $interval = $curentdate->diffInDays($to);
        return $interval;
    }

    public function expiryStatus()
    {
        $curentdate = Carbon::now();
        if($this->to_date > $curentdate){
        return '<span class="badge badge-soft-success">Ongoing</span>';
        } else {
        return '<span class="badge badge-soft-danger">Expired</span>';
        }
    }

    public function arrearspaid()
    {
        $date = Carbon::now()->subdays(1);
        $total = $this->schedules->where('from_date','<',$date)->where('balance','>',0)->reduce(function ($carry, $item) {
        return $carry + $item->paid;
        });

        return $total;
    }



    public function reportamountTotal(int $id)
    {
        $total = $this->schedules->reduce(function ($carry, $item) use($id) {
        return $carry + $item->reportamount($id);
        });
        return $total;
    }

    public function reportpaidamountTotal(int $id)
    {
        $total = $this->schedules->reduce(function ($carry, $item) use($id) {
        return $carry + $item->reportpaidamount($id);
        });
        return $total;
    }



    public function reportbalanceTotal(int $id)
    {
        $total = $this->schedules->reduce(function ($carry, $item) use($id) {
        return $carry + $item->reportbalance($id);
        });
        return $total;
    }

    
    public function tenantunitsprojectionstotal($period,$months,$years)
    {

        if($period == 'MONTHLY'){

            $period_from =  Carbon::createFromFormat('Y-m-d', $months)->startOfMonth();
            $period_to =  Carbon::createFromFormat('Y-m-d', $months)->endOfMonth();

            
            $total = $this->schedules->whereBetween('from_date', [$period_from, $period_to])->reduce(function ($carry, $item) {
                return $carry + $item->expectedamount();
                });

        } else  if($period == 'ANNUALLY'){

            $period_from =  Carbon::createFromFormat('Y-m-d', $years)->startOfYear();
            $period_to =  Carbon::createFromFormat('Y-m-d', $years)->endOfYear();

            $total = $this->schedules->whereBetween('from_date', [$period_from, $period_to])->reduce(function ($carry, $item) use($period,$months,$years) {
                return $carry + $item->expectedamount();
                });
        }

     
        return $total;
    }


    public function canEdit()
    {
    if($this->payments->count() == 0){
        return true;
    }
    }
     public function canEditTenantUnit()
    {
        if(Auth::user()->hasDirectPermission('edit_tenantunit')){
            return true;
        }
        else{
            return false;
        }
    }
    public function candelete()
    {
        if(Auth::user()->hasDirectPermission('delete_tenantunit')){
            return true;
        }
        else{
            return false;
        }
    }


    public function shortFromDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->from_date)->formatLocalized('%d %b,%y');

    }

    public function shortToDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->to_date)->formatLocalized('%d %b, %y');
    }



    public function fromDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->from_date)->formatLocalized('%d %b, %y');
    }

    public function toDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->to_date)->formatLocalized('%d %b, %y');
    }

    public function schedules()
    {
        return $this->hasMany(PaymentSchedule::class,'tenant_unit_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'tenant_unit_id');
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

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class,'schedule_id');
    }

}
