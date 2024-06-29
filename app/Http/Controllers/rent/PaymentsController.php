<?php

namespace App\Http\Controllers\Rent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Rent\iPaymentsService;
use App\Models\Rent\TenantUnit;
use App\Models\CRM\Client;
use App\Models\Rent\Payment;
use App\Http\Requests\Rent\PaymentPost;
use App\Models\Rent\PaymentSchedule;
use App\Models\Accounts\Account;
use App\Models\Accounts\PaymentMode;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
Use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\Main\iFileUploadService;
use PDF;
use App\Models\Rent\PaymentItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     protected $paymentsService;
     protected $fileUploadService;


     public function __construct(iPaymentsService $paymentsService, iFileUploadService $fileUploadService)
     {
         $this->paymentsService = $paymentsService;
         $this->fileUploadService = $fileUploadService;

     }


    public function index(int $id)
    {

        $payments = $this->paymentsService->list($id);
        $doctype = DocumentType::where('code','PAYMENTS')->first();
        $app_url = url('/') . '/uploads/letterheads/leterhead.jpg';

        $filetype = $doctype->id;
        if (Route::current()->middleware()[0] == "api") {
            $formattedPayments = [];
            foreach ($payments as $payment) {
                $formattedItems = [];
                foreach ($payment->items as $item) {
                    $formattedItems[] = [
                        "schedule" => $item->schedule,
                    ];
                }

                $formattedPayment = [
                    "payment_id" => $payment->id,
                    "date" => $payment->date,
                    "amount" => $payment->amount,
                    "amount_due" => $payment->amount_due,
                    "property_name" => $payment->property->name,
                    "unit_name" => $payment->tenantUnit->unit->name,
                    "period" => $payment->tenantUnit->period,
                    "currency" => $payment->tenantUnit->currency,
                    "payment_mode" => $payment->PaymentMode,
                    "payment_account" => $payment->account,
                    "schedules_per_payment" => $formattedItems,
                    "tenant_profile" => $payment->tenantUnit->tenant->clientProfiles,
                    "tenant_type" => $payment->tenantUnit->tenant->clientType,
                    'docid'=> $payment->id,
                    'filetype'=>$filetype,
                    'letter_head'=>$app_url,
                    'can_delete' =>$payment->candelete()

                ];

                $formattedPayments[] = $formattedPayment;
            }

            return response()->json($formattedPayments);
        }
        return view('rent.payments.index', ['payments' => $payments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id)
    {
        $payment = new Payment();
        $tenantunits = TenantUnit::where('property_id',$id)->get();
        $clientids = $tenantunits->pluck('tenant_id');
        $clients = Client::whereIn('id',$clientids)->get();
        $accounts = Account::all();
        $payment->account_id = Account::where('name','Petty Cash')->first();
        $payment->from_date =  Carbon::now()->format('d/m/Y');
        $payment->propertyid = $id;
        $paymentmodes = PaymentMode::all();
        $payment->payment_mode_id = PaymentMode::where('code','CASH')->first();
        $payment->document_type_id = DocumentType::where('code','TUND')->first();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'tenantunits' => $tenantunits,
                'clients' => $clients,
                'accounts' => $accounts,
                'paymentmodes' => $paymentmodes,
            ]);
        }
        return view('rent.payments.create-modal', ['payment' => $payment,'clients'=>$clients,'tenantunits'=>$tenantunits,'accounts'=>$accounts,'paymentmodes'=>$paymentmodes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentPost $request)
    {
        try {
            $payment = $this->paymentsService->create($request);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'message' => 'payment made successfully',
                ], 201);
            }

            if (request()->ajax()) {

                return response()->json(
                    [
                        'message' => 'success',
                        'url' => route('rent.payments.list', $request->property_id),
                        'target' => '#payment-tab-loader'
                    ], 200);

            } else {
                return redirect()->route('rent.payments.show',$payment);
            }


        } catch (Exception $e) {
            // return some other error, or rethrow as above.

            if (request()->ajax()) {

                return response()->json(
                    [
                        'errors' => [$e->getMessage()],
                        'url' => '',
                    ], 400);

            } else {
                Log::debug($e);
                Session::flash('error','Oops! something went wrong.');
                return back()->withErrors(['e' => $e->getMessage()])->withInput();
            }


        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = $this->paymentsService->get($id);
        $doctype = DocumentType::where('code','PAYMENTS')->first();
        $documents = Document::where('external_key',$id)->where('document_type_id',$doctype->id)->get();

        $docid = $id;
        $filetype = $doctype->id;
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                 $payment,

            ], 200);
        }
        return view('rent.payments.show', ['payment' => $payment,'documents'=>$documents,'filetype'=>$filetype,'docid'=>$docid]);

    }


    public function print(int $id)
    {

        $payment = $this->paymentsService->get($id);

        $pdf = PDF::loadView('rent.payments.print', ['payment' => $payment]);
        $pdf->stream('payment_' . $payment->id . '_' .$payment->date() . '.pdf');
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                $payment,

            ]

            );
        }
    }


    public function documents($id)
    {

        $payment = $this->paymentsService->get($id);
        $documents = $payment->documents();

        return view('documents.documents-table', ['documents' => $documents]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findorfail($id);
        $tenantunits = TenantUnit::where('property_id',$payment->property_id)->get();
        $clientids = $tenantunits->pluck('tenant_id');
        $clients = Client::whereIn('id',$clientids)->get();
        $accounts = Account::all();
        $payment->account_id = Account::where('name','Petty Cash')->first();
        $payment->date =  Carbon::createFromFormat('Y-m-d', $payment->date)->format('d/m/Y');
        $payment->propertyid = $id;
        $paymentmodes = PaymentMode::all();
        $payment->payment_mode_id = PaymentMode::where('code','CASH')->first();
        $payment->document_type_id = DocumentType::where('code','TUND')->first();

        return view('rent.payments.edit-modal', ['payment' => $payment,'clients'=>$clients,'tenantunits'=>$tenantunits,'accounts'=>$accounts,'paymentmodes'=>$paymentmodes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

     public function delete(string $id)
     {
      $payment =  Payment::findorfail($id);
      $propertyid = $payment->property_id;


       $this->paymentsService->delete($id);
       if(Route::current()->middleware()[0]=="api"){

        return response()->json([
        "message"=> "payment deleted successfully",
        ]);
    }
       Session::flash('success','');
       return redirect()->route('rent.properties.show', $propertyid);

     }

    public function destroy(string $id)
    {
        //
    }


}
