<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rent\PaymentSchedule;
use Carbon\Carbon;

class InvoiceItem extends Model
{
    use HasFactory;

    public function schedule()
    {
        return $this->belongsTo(PaymentSchedule::class, 'schedule_id');
    }

    public function getFromDateAttribute()
    {
        return $this->schedule ? Carbon::parse($this->schedule->from_date)->format('d M, y') : null;
    }

    public function getToDateAttribute()
    {
        return $this->schedule ? Carbon::parse($this->schedule->to_date)->format('d M, y') : null;

}
}