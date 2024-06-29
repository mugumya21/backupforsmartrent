@extends('layouts.print')
@section('title', 'Invoice')

@section('head-css')
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            width: 1000px;

        }

        p {
            line-height: normal;
        }

        .clearfix {
            margin: 0px;
        }

        .terms {
            padding: 0px;

        }
    
        
        .margin-bellow {
            margin-top: 8px;
        }

        .title .center-block {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            text-decoration: underline !important;
        }

        h3 {

            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;

        }

        .companyname {
            font-style: italic;
            font-weight: bold;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;

        }

        table {
            border-bottom: none;
            border-left: none;
        }

        table td.no-border {

        }

        table tfoot {
            font-weight: bold;
        }

        span.value {
            font-weight: normal;
        }

        .bank {
            padding: 0px;
            margin-top: 70px;
        }

        .terms {
            padding: 0px;

        }

        thead {
            background: #000;
        }

        thead th {
            padding: 7px !Important;
            color: #fff;
            font-size: 12x;
            text-transform: uppercase;
        }

        .spacervv {
            padding: 10px !important;
            width: 100% !important;
            height: 50px !important;
        }

        .center-block {
            font-weight: 900;
            font-size: 30px;
            margin-top: 10px;
            text-decoration: none !important;
        }

        .blabel {
            font-weight: bold;
        }

        .pull-left {
            width: 40%;
            margin: 0px;
        }

        .pull-right {
            width: 40%;
            margin: 0px;
            text-align: right;
        }

        .nomagin p {
            margin: 0px !important;
        }


        td {
            padding: 5px;
            font-size: 18px;
        }

        .alignright {
            text-align: right;
        }

        .sig{
            border: 0px;
        }

        .sig{
            vertical-align: top;
        }
       


    </style>
@endsection

@section('content')
    <div class="headed">
    </div>
    <div style="text-align:center;">

        <img src="{{ asset("assets/img/leterhead.jpg") }}" class="" alt="Avatar"/> 

       </div>

    <div class="title margin-bellow">
        <div class="center-block"><h3>{{ $invoice->invoiceType->name }}</h3></div>
    </div>
    <div class="clearfix margin-bellow">
        <div class="pull-left">
            <p><label class="blabel">Invoice No.</label>
                <span class="value">{{ $invoice->number }}</span>
                <div style="clear:both;"></div>

                <label class="blabel">Bill To Tenant:</label> 
                <span class="m-0 d-print-none" style="text-transform: uppercase;"><b>{{$invoice->client->clientname()}}</b>
                </span>
                <div style="clear:both;"></div>

                <label class="blabel">Unit Name/No:</label> 
                <span class="m-0 d-print-none" style="text-transform: uppercase;">{{$invoice->unit->name}}
                </span>
                <div style="clear:both;"></div>
            
            </p>
        </div>
        <div class="pull-right">
            <p>
                <label class="blabel">Date: </label>
                <span class="value">{{$invoice->date()}}</span><br>
            </p>
        </div>
        <br>
        <div style="clear:both;"></div>
        <hr>
    </div>

    <div>
        <h3>Invoice Details</h3>
    </div>
    <div class="margin-bellow">

        @include('accounts.invoices.items-table', ['invoice' => $invoice])
    </div>

<br><br>
<div class="margin-bellow" style="text-transform: capitalize">
      <b>Invoiced Amount:</b> <u>{{$invoice->amountpaidWords()}}</u>
    </div>
    <div class="margin-bellow">
        <b>Bank Details:</b>  {!! $invoice->account->number !!}
    </div>

    <div class="margin-bellow">
        <b>Description: </b> {{$invoice->description}}
    </div>
   
    <div class="invoice_terms margin-bellow">
        <div class="invoice_terms_title">
            <h4 style="font-style:italic;text-decoration:underline;">Payment Terms</h4>
        </div>
        <div class="terms">
            {!! $invoice->terms  !!}
        </div>
    </div>

    <div style="clear:both;"></div>
<br><br>


<table class="sig" style="width:100%;" border='0'>

<tr><td style="border:0px;"><div><b>Invoiced by:</b>  {{Auth::user()->employee->full_name()}}</div>
    <div style="clear:both;"></div>
    
    <td style="border:0px;">
       
    </td></tr>

</table>

@endsection
