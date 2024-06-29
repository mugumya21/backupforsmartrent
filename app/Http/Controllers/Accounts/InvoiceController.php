<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Accounts\iInvoiceService;
use App\Services\Accounts\iCurrencyService;
use App\Services\HR\iEmployeeService;
use App\Models\Accounts\Currency;
use App\Models\Accounts\InvoiceType;
use App\Models\Accounts\Account;
use App\Models\Accounts\InvoiceItem;

use App\Models\Accounts\Invoice;
use App\Models\Accounts\Tax;
use Carbon\Carbon;
use App\Models\Rent\Property;
use Illuminate\Support\Facades\Auth;
use App\Models\Rent\PaymentSchedule;
use App\Http\Requests\Accounts\InvoicePost;
use Illuminate\Support\Facades\Session;
use PDF;
use App\Models\Accounts\PaymentMode;
use App\Models\Rent\Unit;
use App\Models\Rent\TenantUnit;
use App\Models\CRM\Client;
use App\Models\Rent\Payment;
use App\Http\Requests\Rent\PaymentPost;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
Use DB;
use App\Services\Main\iFileUploadService;
use App\Models\Rent\PaymentItem;
use Illuminate\Support\Facades\Route;



class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $invoiceService;
     protected $employeeService;
     protected $currencyService;

     public function __construct(iInvoiceService $invoiceService, iCurrencyService $currencyService, iEmployeeService $employeeService)
     {
         $this->invoiceService = $invoiceService;
         $this->employeeService = $employeeService;
         $this->currencyService = $currencyService;
     }

    public function index()
    {
            $invoices = $this->invoiceService->list();
            if (Route::current()->middleware()[0] == "api") {
                $formattedinvoices = [];
                foreach ($invoices as $invoice) {

                    $formattedinvoice = [
                        "invoice_id" => $invoice->id,
                        "number" => $invoice->number,
                        "date" => $invoice->date,
                        "due_date" => $invoice->due_date,
                        "amount" => $invoice->amount,
                        "balance" => $invoice->balance,
                        "address" => $invoice->address,
                        "terms" => $invoice->terms,

                        "description" => $invoice->description,
                        "is_billed" => $invoice->is_billed,
                        "invoice_type" => $invoice->invoiceType,
                        "invoice_status" => $invoice->invoiceStatus,
                        "currency" => $invoice->currency,
                        "unit" => $invoice->unit,

                        "tenant_unit" => $invoice->tenantunit,
                        "tax" => $invoice->tax,
                        "tenant" => $invoice->tenantunit->tenant->clientProfiles,
                        "done_by" => $invoice->done_by,
                        "supervisor" => $invoice->supervisor,
                        "property_id" => $invoice->property_id,
                        "account" => $invoice->account,
                        "created_by" => $invoice->created_by,
                        "updated_by" => $invoice->updated_by,
                        "created_at" => $invoice->created_at,
                        "updated_at" => $invoice->updated_at,


                    ];

                    $formattedinvoices[] = $formattedinvoice;
                }

                return response()->json($formattedinvoices);
            }
            return view('accounts.invoices.index', ['invoices' => $invoices]);
    }

    public function invoicepayments ()
    {
            $payments = Payment::all();
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'payments' => $payments,
                ]);
            }
            return view('accounts.invoices.payments.index', ['payments' => $payments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoice = new Invoice();
        $invoicetypes = InvoiceType::all();
        $invoice->date = Carbon::now()->format('d/m/Y');
        $invoice->due_date = Carbon::now()->format('d/m/Y');

        $currencies = $this->currencyService->list();
        $invoice->currency_id = $this->currencyService->baseCurrency();
        $accounts = Account::all();
        $properties = Property::all();

        $employees = $this->employeeService->all();
        $invoice->doneby = $employees->where('user_id', Auth::user()->id)->first();
        $invoice->supervisor = $employees->where('user_id', Auth::user()->id)->first();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'payments' => $payments,
            ]);
        }
        $invoice->terms = '<b>1.INVOICE TO BE SETTLED WITHIN 10DAYS OF THE DUE DATE 2. INTEREST 5% WILL BE CHARGED ON ALL OUTSTANDING PAYMENTS. 3. CHEQUES SHOULD BE MADE IN THE NAME OF. 4. RECONCILIATION HAS TO BE DONE WITHIN 7 DAYS OF THE INVOICE DATE</b>';

        return view('accounts.invoices.create', ['invoice' => $invoice,'invoicetypes'=>$invoicetypes,'currencies'=>$currencies,'accounts'=>$accounts,'employees'=>$employees,'properties'=>$properties]);

    }




    public function loadinvoiceitemes(int $id)
    {
           $invoice = Invoice::where('unit_id',$id)->where('is_billed',1)->get();

            $schedules = PaymentSchedule::where('unit_id', $id)->where('invoice_id',null)
            ->where('balance', '>', 0)
            ->orderBy('from_date', 'desc')
            ->get();

           $taxes = Tax::all();
           return view('accounts.invoices.formitems', ['schedules' => $schedules,'taxes'=>$taxes]);


    }


    public function getitems(int $id)
    {

        $invoice = invoice::findorfail($id);
        $items = $invoice->items;

        return view('accounts.invoices.getperiods', ['items' => $items]);

    }


    public function getpropertyunits(int $id)
    {
         $property = Property::where('id',$id)->first();
        //  $tenantunits = TenantUnit::where('property_id',$property->id)->get();

         $tenantunits = TenantUnit::leftJoin('units', function($join) {
            $join->on('tenant_units.unit_id', '=', 'units.id');
          })->where('tenant_units.property_id',$property->id)->get(['tenant_units.id','units.name']);

         $data = '{"releases":'.$tenantunits.'}';
         return $data;

    }


    public function getdetails(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);
        $response = [
            'property' => $invoice->property,
            'unit' => $invoice->unit,
            'tenantunit' => $invoice->tenantunit,
            'amountdue' => $invoice->balanceDisp(),
        ];

        return response()->json($response);
    }


    public function loadinvoiceitemesOnEdit(int $id)
    {
           $items = InvoiceItem::where('invoice_id',$id)->get();
           $itemids = $items->pluck('schedule_id');
           $schedules = PaymentSchedule::whereIn('id',$itemids)->get();
           $taxes = Tax::all();
           $invoice = Invoice::findorfail($id);

           return view('accounts.invoices.formitems-edit', ['schedules' => $schedules,'taxes'=>$taxes,'tax_id'=>$invoice->tax_id,'invoice'=>$invoice]);
    }




    public function computeinvoiceamount(Request $request)
    {

        $array = collect($request->ids);
        $balances = $array->map(function($id) {
        $paymentschedule =  PaymentSchedule::where('id',$id)->first();
        $balance = $paymentschedule->balance;

        return $balance;

        });

        $sum_balances = number_format($balances->sum(), 0);
        $sum_balance_figure = $balances->sum();
        $data = $sum_balances;

        $tax = Tax::where('id',$request->taxid)->first();
        $taxamount = ($tax->rate /100 * $sum_balance_figure) + ($sum_balance_figure);

        return response()->json([
        'amount'=>$data,
        'taxamount'=> number_format($taxamount, 0)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoicePost $request)
    {
        try {
            $invoice = $this->invoiceService->create($request);
            if(Route::current()->middleware()[0]=="api"){

                return response()->json([
                    'invoice' => $invoice,
                ]);
            }
            if (request()->ajax()) {

                return response()->json(
                    [
                        'message' => 'success',
                        'url' => route('rent.invoices.list', $request->property_id),
                        'target' => '#invoice-tab-loader'
                    ], 200);

            } else {
                return redirect()->route('accounts.invoices.index');
            }
            Session::flash('success','Awesome! that was successful');
            return redirect()->route('accounts.invoices.show', $invoice);
        } catch (Exception $e) {
            Log::debug($e);
            Session::flash('error','Oops! something went wrong.');
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!Auth::user()->hasAnyDirectPermission(['view_invoice','list_invoice'])){
            abort(401);
        }

        $invoice = $this->invoiceService->get($id);
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                "invoice "=>  $invoice,
            ], 200);
        }

        return view('accounts.invoices.show', ['invoice' => $invoice]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::findorfail($id);
        $invoicetypes = InvoiceType::all();
        $invoice->date = Carbon::createFromFormat('Y-m-d', $invoice->date)->format('d/m/Y');
        $invoice->due_date = Carbon::createFromFormat('Y-m-d', $invoice->due_date)->format('d/m/Y');

        $currencies = $this->currencyService->list();
        $invoice->currency_id = $invoice->currency_id;
        $accounts = Account::all();
        $properties = Property::all();

        $employees = $this->employeeService->all();
        $invoice->doneby = $invoice->done_by;
        $invoice->supervisor = $invoice->supervisor;

        $invoice->terms = $invoice->terms;

        return view('accounts.invoices.edit', ['invoice' => $invoice,'invoicetypes'=>$invoicetypes,'currencies'=>$currencies,'accounts'=>$accounts,'employees'=>$employees,'properties'=>$properties]);
    }


    public function delete(string $id)
    {

        if(!Auth::user()->hasAnyDirectPermission(['delete_invoice'])){
            abort(401);
        }

      $invoice =  Invoice::findorfail($id);
      $this->invoiceService->delete($id);
      Session::flash('success','Invoice was deleted!');
      return redirect()->route('accounts.invoices.index');

    }

    public function print(int $id)
    {

        $invoice = $this->invoiceService->get($id);

        // return view('accounts.invoices.print', ['invoice' => $invoice]);
        $pdf = PDF::loadView('accounts.invoices.print', ['invoice' => $invoice]);
        $pdf->stream('invoice_' . $invoice->id . '_' .$invoice->date() . '.pdf');
    }


    public function approve(int $id)
    {
    $invoice = $this->invoiceService->get($id);
    return view('accounts.invoices.approve-modal', ['invoice' => $invoice]);
    }

    public function approveSubmit(Request $request, int $id)
    {
    $invoice = $this->invoiceService->approveSubmit($request, $id);
    return redirect()->route('accounts.invoices.show', $invoice);
    }



    public function paymentSubmit(Request $request)
    {
        try {

            $invoice = $this->invoiceService->payment($request);

            Session::flash('success','Awesome! that was successful');
            return redirect()->route('accounts.invoices.show', $invoice);
        } catch (Exception $e) {
            Log::debug($e);
            Session::flash('error','Oops! something went wrong.');
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }



    public function prepaymentsSubmit(Request $request)
    {
        try {

            $payment = $this->invoiceService->prepaymentsSubmit($request);

            Session::flash('success','Awesome! that was successful');
            return redirect()->route('accounts.invoices.invoicepayments');
        } catch (Exception $e) {
            Log::debug($e);
            Session::flash('error','Oops! something went wrong.');
            return back()->withErrors(['e' => $e->getMessage()])->withInput();
        }
    }


    public function invoicepaymentscreate ()
    {
        $id='20';
        $payment = new Payment();
        $tenantunits = TenantUnit::where('property_id',$id)->get();
        $clientids = $tenantunits->pluck('tenant_id');
        $clients = Client::whereIn('id',$clientids)->get();
        $accounts = Account::all();
        $properties = Property::all();
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
        return view('accounts.invoices.payments.payment-create', ['payment' => $payment,'clients'=>$clients,'tenantunits'=>$tenantunits,'accounts'=>$accounts,'paymentmodes'=>$paymentmodes,'properties'=>$properties]);
    }


    public function invoicepaymentsinvoicedcreate ()
    {
        $id='20';
        $payment = new Payment();
        $tenantunits = TenantUnit::where('property_id',$id)->get();
        $clientids = $tenantunits->pluck('tenant_id');
        $clients = Client::whereIn('id',$clientids)->get();
        $accounts = Account::all();
        $invoices = Invoice::all();
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
        return view('accounts.invoices.payments.payment-invoicedcreate', ['payment' => $payment,'clients'=>$clients,'tenantunits'=>$tenantunits,'accounts'=>$accounts,'paymentmodes'=>$paymentmodes,'invoices'=>$invoices]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoicePost $request, string $id)
    {
        try {
            $invoice = $this->invoiceService->update($request,$id);

            Session::flash('success','Awesome! that was successful');
            return redirect()->route('accounts.invoices.show', $invoice);
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
   public function invoicesonproperty(string $id)
    {

         $invoices = $this->invoiceService->invoicesonproperty($id);

        return view('accounts.invoices.invoices_on_property', ['invoices' => $invoices]);

    }

}