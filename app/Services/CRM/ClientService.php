<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 05/04/2018
 * Time: 20:45
 */

namespace App\Services\CRM;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CRM\ClientPost;
use App\Models\CRM\Client;
use App\Models\CRM\ClientType;
use App\Models\Main\Nation;
use App\Models\CRM\ClientProfileContact;
use App\Models\CRM\ClientProfile;
use App\Models\CRM\ClientProfileNextOfKin;
use App\Models\CRM\ClientProfileNextOfKinContact;
use App\Models\Main\ContactType;
use DB;



class ClientService implements iClientService
{

    public function create(ClientPost $request)
    {

        $clienttype = ClientType::where('code', $request->clienttype)->first();
        $emailcontact = ContactType::where('code', 'EMAIL')->first();
        $telcontact = ContactType::where('code', 'TELEPHONE')->first();

        DB::beginTransaction();
        try {
            $client = new Client();
            $client->number = $this->nextNumber($request);
            $client->client_type_id = $clienttype->id ;
            $client->created_by = Auth::id();
            $client->save();

            $clientprofile = new ClientProfile();
            if( $clienttype->code == 'IND'){
            $clientprofile->first_name = $request->first_name;

            } else {
            $clientprofile->first_name = $request->company_name;
            }

            $clientprofile->last_name = $request->last_name;
            $clientprofile->company_name = $request->company_name;
            $clientprofile->middle_name = $request->middle_name;
            $clientprofile->date_of_birth = isset($request->date_of_birth) ?
                Carbon::createFromFormat('d/m/Y', $request->date_of_birth) : null;
            $clientprofile->gender = $request->gender;
            $clientprofile->address = $request->address;
            $clientprofile->tin  = $request->tin;
            $clientprofile->id_number  = $request->id_number;
            $clientprofile->nin  = $request->nin;
            $clientprofile->designation  = $request->designation;
            $clientprofile->nation_id   = $request->nation_id ;
            $clientprofile->client_id = $client->id;
            $clientprofile->created_by = Auth::id();
            $clientprofile->save();

            if($request->email){
                $clientProfileemail = new ClientProfileContact();
                $clientProfileemail->value = $request->email;
                $clientProfileemail->contact_type_id = $emailcontact->id;
                $clientProfileemail->client_profile_id = $clientprofile->id;
                $clientProfileemail->created_by = Auth::id();
                $clientProfileemail->save();
            }

            if($request->telephone){
                $clientProfiletel = new ClientProfileContact();
                $clientProfiletel->value = $request->telephone;
                $clientProfiletel->contact_type_id = $telcontact->id;
                $clientProfiletel->client_profile_id = $clientprofile->id;
                $clientProfiletel->created_by = Auth::id();
                $clientProfiletel->save();
            }

            DB::commit();
            return $client;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return Client::with(['clientType', 'clientProfiles', 'clientProfiles.clientProfileContacts'])
            ->findOrFail($id);
    }

    public function list()
    {
        $clients = Client::with(['clientType', 'clientProfiles', 'clientProfiles.clientProfileContacts']);


        return $clients->latest()->orderBy('id', 'desc')->get();
    }

    public function nextNumber($request)
    {

        $cienttype = ClientType::where('code', $request->clienttype)->first();
        $date = Carbon::now()->format('YmdHis');
        if($cienttype->code == 'IND'){
            $clientCode = 'I';
        } else {
            $clientCode = 'C';
        }

        return ''. $clientCode.'-'.$date.'';

    }



    public function update(ClientPost $request)
    {

        $clienttype = ClientType::where('code', $request->clienttype)->first();
        $emailcontact = ContactType::where('code', 'EMAIL')->first();
        $telcontact = ContactType::where('code', 'TELEPHONE')->first();

        DB::beginTransaction();
        try {

            $client = Client::findorfail($request->client_id);
            $clientprofile = ClientProfile::findorfail($client->currentclientProfile()->id);

            if( $clienttype->code == 'IND'){
            $clientprofile->first_name = $request->first_name;
            } else {
            $clientprofile->first_name = $request->company_name;
            }

            $clientprofile->last_name = $request->last_name;
            $clientprofile->company_name = $request->company_name;
            $clientprofile->middle_name = $request->middle_name;
            $clientprofile->date_of_birth = isset($request->date_of_birth) ?
                Carbon::createFromFormat('d/m/Y', $request->date_of_birth) : null;

            $clientprofile->gender = $request->gender;
            $clientprofile->address = $request->address;
            $clientprofile->tin  = $request->tin;
            $clientprofile->nin  = $request->nin;
            $clientprofile->id_number  = $request->id_number;
            $clientprofile->designation  = $request->designation;
            $clientprofile->nation_id   = $request->nation_id ;
            $clientprofile->client_id = $client->id;
            $clientprofile->description = $request->description;
            $clientprofile->updated_by = Auth::id();
            $clientprofile->save();

if($request->email){
    $clientProfileemail = new ClientProfileContact();
    $clientProfileemail->value = $request->email;
    $clientProfileemail->contact_type_id = $emailcontact->id;
    $clientProfileemail->client_profile_id = $clientprofile->id;
    $clientProfileemail->created_by = Auth::id();
    $clientProfileemail->save();
}

if($request->telephone){
            $clientProfiletel = new ClientProfileContact();
            $clientProfiletel->value = $request->telephone;
            $clientProfiletel->contact_type_id = $telcontact->id;
            $clientProfiletel->client_profile_id = $clientprofile->id;
            $clientProfiletel->created_by = Auth::id();
            $clientProfiletel->save();
}

            DB::commit();
            return $client;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


}
