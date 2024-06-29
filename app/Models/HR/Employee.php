<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin\Branch;
use App\Models\HR\MaritalStatus;


class Employee extends Model
{
    use HasFactory;


        
    public function full_name()
    {
        $fullName = $this->middle_name != '' ?
            "{$this->first_name} {$this->middle_name} {$this->last_name}"
            : "{$this->first_name} {$this->last_name}";

               return $fullName;
    }

    public function getFullNameAttribute()
    {
        $fullName = $this->middle_name != '' ?
        "{$this->first_name} {$this->middle_name} {$this->last_name}"
        : "{$this->first_name} {$this->last_name}";

           return $fullName;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function avatar()
    {

    $avatar =   EmployeeAvatar::where('employee_id', $this->id)->orderBy('id','desc')->first();
    return $avatar;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class,'marital_status_id');
    }

    public function employeeAvatar()
    {
        return $this->hasOne(EmployeeAvatar::class);
    }

}
