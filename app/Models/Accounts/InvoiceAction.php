<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Accounts\InvoiceStatus;
use App\Models\Accounts\Invoice;
use Carbon\Carbon;

class InvoiceAction extends Model
{
    use HasFactory;

    public function date()
    {
        return $this->created_at->format('d/m/Y');
    
    }
    
    public function invoiceStatus()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
