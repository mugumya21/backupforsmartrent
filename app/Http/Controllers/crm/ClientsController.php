<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CRM\iClientService;
use App\Models\CRM\Client;
use App\Models\Main\Nation;
use App\Models\CRM\ClientProfile;
use App\Models\CRM\ClientProfileContact;
use App\Models\CRM\ClientProfileNextOfKin;
use App\Models\CRM\ClientProfileNextOfKinContact;
use App\Models\CRM\ClientProfileType;
use App\Models\CRM\ClientType;
use App\Services\HR\iEmployeeService;
use App\Models\Admin\Branch;
use App\Models\HR\MaritalStatus;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CRM\ClientPost;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Main\DocumentType;
use App\Services\Main\iDocumentService;
use Auth;
use Illuminate\Support\Facades\Route;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $clientService;
     protected $employeeService;
     protected $documentService;

     public function __construct(iClientService $clientService, iEmployeeService $employeeService, iDocumentService $documentService)
     {
         $this->clientService = $clientService;
         $this->employeeService = $employeeService;
         $this->documentService = $documentService;
     }


    public function index()
    {
        $clients = $this->clientService->list();
        if (Route::current()->middleware()[0] == "api")  {

            return response()->json(
                [
                    'clients' => $clients
                ], 200);
        }
        return view('crm.clients.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $client = new Client();
        $nations = Nation::all();
        $client->nation_id = Nation::where('code','UG')->first();
        $clientProfile = new ClientProfile();
        $nextOfKin = new ClientProfileNextOfKin();
        $clientypes = ClientType::all();
        $branches = Branch::where('is_active', 1)->get();
        $maritalstatuses = MaritalStatus::all();
        $roles = Role::all();
        $employees = $this->employeeService->list();

        $source =$request['source'];

        if($source == 'IND')
        {
            $clientUrl = 'crm.clients.individualClientForm';
        }
        else  if($source == 'COM')
        {
            $clientUrl = 'crm.clients.companyClientForm';
        } else {
            $clientUrl = 'crm.clients.create';
        }
        if(Route::current()->middleware()[0]=="api")
        {

            return response()->json([
                "nations"=>$nations,
                "clientypes"=>$clientypes,
                "branches"=>$branches,
                "roles"=>$roles,
            ]

           );
        }

        return view($clientUrl, ['client' => $client,'employees'=>$employees,'clientProfile'=>$clientProfile,'nextOfKin'=>$nextOfKin,'clientypes'=>$clientypes,'maritalstatuses'=>$maritalstatuses,'branches'=>$branches,'roles'=>$roles,'nations'=>$nations]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientPost $request)
    {

        try {

            $client = $this->clientService->create($request);
            if(Route::current()->middleware()[0]=="api")
            {

                return response()->json([
                    'clientCreatedViaApi' => $client,
                ], 201);
            }

            Session::flash('success','');
            return redirect()->route('crm.clients.show', $client);
        } catch (Exception $e) {
            Log::debug($e);
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }

    }


    public function profilepic($id)
    {

        $client = $this->clientService->get($id);
        $profilepic = $client->featuredImage();

        return view('crm.clients.profilepic', ['profilepic' => $profilepic]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = $this->clientService->get($id);
        $filetype = DocumentType::where('code','TND')->first();
        $filetype = $filetype->id;
        $image = $client->logo();
        if(Route::current()->middleware()[0]=="api") {

            return response()->json(

              $client

           );
        }
        return view('crm.clients.show', ['client' => $client,'docid'=>$client->id,'filetype'=>$filetype,'image'=>$image]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['edit_clients'])){
            abort(401);
        }


        $client = Client::findorfail($id);
        $nations = Nation::all();
        $client->nation_id = Nation::where('code','UG')->first();
        $clientProfile = new ClientProfile();
        $nextOfKin = new ClientProfileNextOfKin();
        if(!empty($client->currentclientProfile()->date_of_birth)){
        $client->dateofbirth =  Carbon::createFromFormat('Y-m-d', $client->currentclientProfile()->date_of_birth)->format('d/m/Y');
                    }


        $clientypes = ClientType::all();
        $branches = Branch::where('is_active', 1)->get();
        $maritalstatuses = MaritalStatus::all();
        $roles = Role::all();
        $employees = $this->employeeService->list();


        return view('crm.clients.edit', ['client' => $client,'employees'=>$employees,'clientProfile'=>$clientProfile,'nextOfKin'=>$nextOfKin,'clientypes'=>$clientypes,'maritalstatuses'=>$maritalstatuses,'branches'=>$branches,'roles'=>$roles,'nations'=>$nations]);


    }

    public function gallery(int $id, int $filetype)
    {
        $images = $this->documentService->gallery($id, $filetype);
        $client = Client::findorfail($id);

        return view('crm.clients.gallery', ['images' => $images,'id'=>$id, 'filetype'=>$filetype,'client'=>$client]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ClientPost $request, string $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['edit_units'])){
            abort(401);
        }

            try {

                $client = $this->clientService->update($request,$id);
                Session::flash('success','Client updated successfully');
                return redirect()->route('crm.clients.show', $client);
            } catch (Exception $e) {
                Log::debug($e);
                Session::flash('error','Oops! something went wrong.');
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
