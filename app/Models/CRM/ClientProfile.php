<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main\ContactType;
use App\Models\Main\Nation;

class ClientProfile extends Model
{
    use HasFactory;


    public function currentProfileEmail()
    {
        $contacttype = ContactType::where('code', 'EMAIL')->first();

        $email = $this->clientProfileContacts->where('client_profile_id',$this->id)->where('contact_type_id',$contacttype->id)->sortByDesc('id')->first();
        if(!empty($email)){
            return $email->value;
        } else {
            return '';
        }

    }


    public function currentProfileTel()
    {
        $contacttype = ContactType::where('code', 'TELEPHONE')->first();

        $tel = $this->clientProfileContacts->where('client_profile_id',$this->id)->where('contact_type_id',$contacttype->id)->sortByDesc('id')->first();

        if(!empty($tel)){
            return $tel->value;
        } else {
            return '';
        }
        

        return $tel;
       
    }

    public function clientProfileContacts()
    {
        return $this->hasMany(ClientProfileContact::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }


}
