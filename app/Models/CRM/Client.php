<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main\Nation;
use App\Models\Rent\TenantUnit;
use App\Models\Main\ContactType;
use App\Models\Main\Document;
use App\Models\Main\DocumentType;
use App\Models\Main\DocumentStatus;

class Client extends Model
{
    use HasFactory;

    protected $dates = ['date_of_birth'];

    public function clientname()
    {
       if($this->clientType->code == 'IND'){
        $clientprofile = $this->clientProfiles->first();
        $name = ''. $clientprofile->first_name.' '.$clientprofile->last_name.'';
       } else {
        $clientprofile =  $this->clientProfiles->first();
        $name = $clientprofile->company_name;

       }
      
        return $name;
       
    }

            public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
        {
            if($this->clientType->code == 'IND'){
                $clientprofile = $this->clientProfiles->first();
                $name = ''. $clientprofile->first_name.' '.$clientprofile->last_name.'';
            } else {
                $clientprofile =  $this->clientProfiles->first();
                $name = $clientprofile->company_name;

            }
            
                return $name;
        }


    
    public function logo()
    {
    $type = DocumentType::where('code','CLIENTLOGO')->first();
    $status = DocumentStatus::where('code','CLIENTLOGO')->first();
    $image =   Document::where('external_key', $this->id)->where('document_type_id', $type->id)->where('document_status_id', $status->id)->orderBy('id','desc')->first();
    return $image;
    }


    
    public function featuredImage()
    {

    $document =   Document::where('external_key', $this->id)->where('is_featured', 1)->first();
    return $document;

    }


    public function documenttype()
    {
      $type =   DocumentType::where('code','TND')->first();
      return $type;
    }

    public function currentclientProfile()
    {
       return $this->clientProfiles->sortByDesc('id')->first();
    }


    public function tenantunits()
    {
        return $this->hasMany(TenantUnit::class,'tenant_id');
    }
  

    public function clientProfiles()
    {
        return $this->hasMany(ClientProfile::class);
    }

    public function clientType()
    {
        return $this->belongsTo(ClientType::class);
    }

    public function inCharge()
    {
        return $this->belongsToMany(Employee::class, 'client_in_charge',
            'client_id', 'employee_id')
            ->using(ClientInCharge::class)
            ->withPivot('created_by', 'updated_by')
            ->as('inCharge')
            ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
