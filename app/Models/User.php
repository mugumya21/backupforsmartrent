<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeAvatar;
use Auth;
use Carbon\Carbon;
use App\Models\Main\DocumentType;
use App\Models\System\modelHasRoles;
use App\Models\System\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected function getDefaultGuardName(): string
    {
        return 'web';
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function avatar()
    {
    $avatar =   EmployeeAvatar::where('employee_id', $this->id)->orderBy('id','desc')->first();
    return $avatar;
    }

    public function statusDisp()
    {
        if($this->is_active > 0){
            return '<span class="badge rounded-pill bg-success">Active</span>';
        }
        else {
            return '<span class="badge rounded-pill bg-warning">In-Active</span>';
        }
    }

    public function documenttype()
    {
      $type =   DocumentType::where('code','EMP')->first();
      return $type;
    }

    public function currentRole(){
    $role =   modelHasRoles::where('model_id',$this->id)->orderby('created_at','desc')->first();
    $currentrole = Role::where('id',$role->role_id)->first();
    return $currentrole;
    }

    public function userRoles(){
        $modelroles =   modelHasRoles::where('model_id',$this->id)->get();
        $rolesids = $modelroles->pluck('role_id');
        $currentroles = Role::whereIn('id',$rolesids)->get();
        return $currentroles;
        }

    public function isactive(){
      if($this->is_active > 0){
        return true;
      }
        }


}