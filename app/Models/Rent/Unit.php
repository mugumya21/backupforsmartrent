<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rent\UnitType;
use App\Models\Accounts\Currency;
use Illuminate\Support\Facades\Auth;

class Unit extends Model
{
    use HasFactory;

    public function amountDisp()
    {
        return number_format($this->amount, 0);
    }

    public function createdDate()
    {
        return $this->created_at->format('d/m/Y');
    }
    public function canedit()
    {
        if(Auth::user()->hasDirectPermission('edit_units')){
            return true;
        }
        else{
            return false;
        }
    }
    public function candelete()
    {
        if(Auth::user()->hasDirectPermission('delete_units')){
            return true;
        }
        else{
            return false;
        }
    }
    public function availabilityDisp()
    {

        if($this->is_available > 0){
            return '<span class="badge badge-soft-success">Vacant</span>';
        }  else {
            return '<span class="badge rounded-pill badge-soft-danger">Is Taken</span> ';

        }
    }


    public function tenantunitamount()
    {

        if(!empty($this->tenantunit)){
            $amount = $this->tenantunit->converted_discount_amount;
        } else {
            $amount = 0;
        }
        return $amount;

    }


    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }


    public function tenantunit()
    {
        return $this->hasone(TenantUnit::class,'unit_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }

    public function unitType()
    {
        return $this->belongsTo(UnitType::class,'unit_type');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class,'schedule_id');
    }


}
