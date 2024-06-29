<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Models\System\User;

class CurrencyRate extends Model
{
    use HasFactory;

    protected $dates = [
        'date'
    ];

    public function setBuyingAttribute($value)
    {
        $this->attributes['buying'] = str_replace(',', '', $value);
    }

    public function setSellingAttribute($value)
    {
        $this->attributes['selling'] = str_replace(',', '', $value);
    }

    public function buyingDisp()
    {
        return number_format($this->buying, 2);
    }

    public function sellingDisp()
    {
        return number_format($this->selling, 2);
    }

    public function dropdownDisp()
    {
        return "{$this->buying}/{$this->selling}";
    }

    public function dateDisp()
    {
        if($this->date)
        {
            return Carbon::createFromFormat('Y-m-d', $this->date)->formatLocalized('%d %b, %Y'); 
        }
    }

 

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


}
