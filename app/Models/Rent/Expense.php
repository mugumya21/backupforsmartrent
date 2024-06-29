<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Accounts\Currency;
use App\Models\Accounts\ExpenseType;
use App\Models\Rent\Expense;
use App\Models\Rent\ExpenseAction;
use App\Models\HR\Employee;
use App\Models\Accounts\Tax;
use App\Models\Rent\ExpenseStatus;
use Rmunate\Utilities\SpellNumber;
use App\Models\System\Setting;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;

class Expense extends Model
{
    use HasFactory;

    public function amountDisp()
    {
        return number_format($this->amount, 0);
    }

    public function expenseStatusDisp()
    {
        if ($this->ExpenseStatus->code == 'APPROVED') {
            return "  <span class='badge rounded-pill badge-soft-success'>APPROVED</span>";
        } else if ($this->ExpenseStatus->code == 'REJECTED') {
            return "<span class='badge rounded-pill badge-soft-danger'>REJECTED</span>";
        } else if ($this->ExpenseStatus->code == 'RETURNED') {
            return "<span class='badge rounded-pill badge-soft-warning'>RETURNED</span>";
        } else if ($this->ExpenseStatus->code == 'SUBMITTED') {
            return " <span class='badge rounded-pill badge-soft-secondary'>SUBMITTED</span>";
        } else if ($this->ExpenseStatus->code == 'EDITED') {
            return "<span class='badge rounded-pill badge-soft-info'>EDITED</span>";
        }
    }
    
    public function canApprove()
    {
        if($this->expenseStatus->code == 'SUBMITTED' || $this->expenseStatus->code == 'EDITED'){
            return true;
        }
    }

    public function expenseStatus()
    {
        return $this->belongsTo(ExpenseStatus::class,'expense_status_id');
    }

    public function dateDisp()
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)->format('d/m/Y');
    }
    
    public function documents()
    {
      $type =   DocumentType::where('code','EXPENSES')->first();
      $documents =   Document::where('external_key', $this->id)->where('document_type_id', $type->id)->get();
      return $documents;
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function expenseActions()
    {
        return $this->hasMany(ExpenseAction::class,'expense_id');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function actions()
    {
        return $this->hasMany(ExpenseAction::class,'expense_id');
    }


    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }

}
