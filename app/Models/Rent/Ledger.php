<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rent\TenantUnit;
use Carbon\Carbon;

class Ledger extends Model
{
    use HasFactory;


    public function shortDate()
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)->formatLocalized('%d %b, %y');

    }

    public function debitDisp()
    {
        return number_format($this->debit, 0);
    }

    public function creditDisp()
    {
        return number_format($this->credit, 0);
    }

    public function balanceDisp()
    {
        return number_format($this->balance, 0);
    }



    public function tenantunit()
    {
        return $this->belongsTo(TenantUnit::class, 'tenant_unit_id');
    }
}
