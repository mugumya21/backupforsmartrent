<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaymentItem extends Model
{
    use HasFactory;


    public function balanceDisp()
    {
        return number_format($this->balance(), 0);
    }

    public function balance()
    {

        $total = $this->balance;

        return $total;
    }




    public function paidamountDisp()
    {
        return number_format($this->paid(), 0);
    }

    public function paid()
    {

        $total = $this->paid;
        return $total;
    }


    public function schedule()
    {
        return $this->belongsTo(PaymentSchedule::class,'payment_schedule_id');
    }
       public function getFromDateAttribute()
    {
        return $this->schedule ? Carbon::parse($this->schedule->from_date)->format('d M, y') : null;
    }

    public function getToDateAttribute()
    {
        return $this->schedule ? Carbon::parse($this->schedule->to_date)->format('d M, y') : null;

}

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }

}
