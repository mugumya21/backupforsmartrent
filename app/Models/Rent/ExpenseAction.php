<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Accounts\ExpenseStatus;
use App\Models\Accounts\Expense;
use Carbon\Carbon;

class ExpenseAction extends Model
{
    use HasFactory;

    public function date()
    {
        return $this->created_at->format('d/m/Y');
    
    }
    
    public function status()
    {
        return $this->belongsTo(ExpenseStatus::class, 'expense_status_id');
    }

    public function expense()
    {
        return $this->belongsTo(expense::class, 'expense_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
