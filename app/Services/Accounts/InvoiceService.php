<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 05/04/2018
 * Time: 20:45
 */

namespace App\Services\Accounts;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Accounts\InvoicePost;
use App\Models\Accounts\Invoice;
use App\Models\Accounts\InvoiceStatus;
use App\Models\Accounts\InvoiceItem;
use App\Models\Rent\Ledger;
use App\Models\Accounts\InvoiceAction;
use DB;
use Illuminate\Http\Request;
use App\Models\Rent\PaymentSchedule;

class InvoiceService implements iInvoiceService
{
    public function create(InvoicePost $request)
    {
        $invoiceStatus = InvoiceStatus::where('code', 'SUBMITTED')->first();

        DB::beginTransaction();
        try {
            $invoice = new invoice();
            $invoice->number = $this->nextNumber();
            $invoice->date =  Carbon::createFromFormat('d/m/Y', $request->date);
            $invoice->due_date =  Carbon::createFromFormat('d/m/Y', $request->due_date);
            $invoice->amount = str_replace(',', '', $request->amount);
            $invoice->balance = str_replace(',', '', $request->amount);
            $invoice->address = $request->address;
            $invoice->terms = $request->terms;
            $invoice->invoice_type_id  = $request->invoice_type_id;
            $invoice->invoice_status_id  = $invoiceStatus->id;
            $invoice->currency_id  = $request->currency_id;
            $invoice->unit_id  = $request->unit_id;
            $invoice->tenant_unit_id   = $request->tenant_unit_id;
            $invoice->tenant_id   = $request->tenant_id;
            $invoice->tax_id   = $request->tax_id;
            $invoice->done_by   = $request->done_by;
            $invoice->supervisor    = $request->supervisor;
            $invoice->property_id    = $request->property_id;
            $invoice->account_id    = $request->account_id;
            $invoice->description    = $request->description;

            $invoice->created_by = Auth::id();
            $invoice->save();
            $dates = [];
            foreach($request->schedule_ids as $id){

            $item = new InvoiceItem();
            $item->schedule_id = $id;
            $item->invoice_id = $invoice->id;
            $item->created_by = Auth::id();
            $item->save();

            $paymentschedule = PaymentSchedule::find($id);
            $paymentschedule->invoice_id = $invoice->id;
            $paymentschedule->save();
            }


            $invoiceAction = new InvoiceAction();
            $invoiceAction->comment = 'Submitted for approval';
            $invoiceAction->invoice_status_id = $invoiceStatus->id;
            $invoiceAction->invoice_id = $invoice->id;
            $invoiceAction->created_by = Auth::id();
            $invoiceAction->save();

            DB::commit();
            return $invoice;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function get(int $id)
    {
        return invoice::with(['invoiceType'])->findOrFail($id);
    }


    public function approveSubmit(Request $request, int $id)
    {
        $invoiceStatus = InvoiceStatus::where('code', 'APPROVED')->first();
        if (!$invoiceStatus) throw new Exception('Invoice status with code APPROVED not found in system.');

        DB::beginTransaction();
        try {
            $invoice = Invoice::findorfail($id);
            $invoice->invoice_status_id  = $invoiceStatus->id;
            $invoice->is_billed  = 1;
            $invoice->updated_by = Auth::id();
            $invoice->save();



            $invoiceAction = new InvoiceAction();
            $invoiceAction->comment = $request->comment;
            $invoiceAction->invoice_status_id = $invoiceStatus->id;
            $invoiceAction->invoice_id = $invoice->id;
            $invoiceAction->created_by = Auth::id();
            $invoiceAction->save();

            // $status = InvoiceStatus::where('code','APPROVED')->first();
            // $action = InvoiceAction::where('invoice_status_id', $status->id)
            // ->where('invoice_id', $invoice->id)
            // ->orderBy('created_at', 'desc')
            // ->first();
       $invoiceItems = $invoice->items;

        $dates = [];
        foreach ($invoiceItems as $invoiceItem) {
            if ($invoiceItem->from_date && $invoiceItem->to_date) {
                $dates[] = '(' . $invoiceItem->from_date . ' - ' . $invoiceItem->to_date . ')';
            }
        }
                $ledger = new Ledger();
                $ledger->date = $invoice->date;
                $ledger->invoice_id = $invoice->id;
                $ledger->item = 'Rent Charge';
                $ledger->description = implode(', ', $dates);
                $ledger->debit =$invoice->amount;
                $ledger->credit = 0;
                $ledger->tenant_unit_id = $invoice->tenant_unit_id;
                $ledger->created_by = Auth::id();
                $ledger->save();
            DB::commit();
            return $invoice;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function list()
    {
        $invoices = Invoice::with(['invoiceType']);
        // $payments = Payment::with(['property'])->where('property_id',$id);
        return $invoices->latest()->orderBy('id', 'desc')->get();
    }
    public function invoicesonproperty(string $id)
    {
        $invoices = Invoice::with(['invoiceType'])->where('property_id',$id);
        return $invoices->latest()->orderBy('id', 'desc')->get();
    }

    public function nextNumber()
    {
        $date = Carbon::now()->format('ymdHis');
        return 'P-'.$date.'';

    }


    public function update(InvoicePost $request, int $id)
    {
        $invoiceStatus = InvoiceStatus::where('code', 'EDITED')->first();

        DB::beginTransaction();
        try {
            $invoice = Invoice::findorfail($id);
            $invoice->date =  Carbon::createFromFormat('d/m/Y', $request->date);
            $invoice->due_date =  Carbon::createFromFormat('d/m/Y', $request->due_date);
            $invoice->amount = str_replace(',', '', $request->amount);
            $invoice->address = $request->address;
            $invoice->terms = $request->terms;
            $invoice->invoice_type_id  = $request->invoice_type_id;
            $invoice->invoice_status_id  = $invoiceStatus->id;
            $invoice->currency_id  = $request->currency_id;
            $invoice->unit_id  = $request->unit_id;
            $invoice->tenant_unit_id   = $request->tenant_unit_id;
            $invoice->tenant_id   = $request->tenant_id;
            $invoice->tax_id   = $request->tax_id;
            $invoice->done_by   = $request->done_by;
            $invoice->supervisor    = $request->supervisor;
            $invoice->property_id    = $request->property_id;
            $invoice->account_id    = $request->account_id;
            $invoice->description    = $request->description;
            $invoice->updated_by = Auth::id();
            $invoice->save();

            $invoice->items()->delete();

            foreach($request->schedule_ids as $id){

            $item = new InvoiceItem();
            $item->schedule_id = $id;
            $item->invoice_id = $invoice->id;
            $item->created_by = Auth::id();
            $item->save();

            }

            $invoiceAction = new InvoiceAction();
            $invoiceAction->comment = 'Edited Invoice';
            $invoiceAction->invoice_status_id = $invoiceStatus->id;
            $invoiceAction->invoice_id = $invoice->id;
            $invoiceAction->created_by = Auth::id();
            $invoiceAction->save();

            DB::commit();
            return $invoice;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function delete(int $id)
    {
        $invoice = Invoice::findorfail($id);
        $invoice->items()->delete();
        $invoice->invoiceActions()->delete();
        $invoice->delete();
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

    }



}
