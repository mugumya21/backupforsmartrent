@extends('layouts.print')
@section('title', 'Collections Report')

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

        .margin-bellow {
            margin-top: 15px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline !important;
        }

        h2 {

font-size: 25px;
text-transform:uppercase;

}


        h3 {

            font-size: 20px;
            font-weight: bold;
            text-transform: capitalize;
            margin-top: 10px;
            margin-bottom: 0px;

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
            font-size: 20px;
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
            margin-top: 40px;
            text-decoration: none !important;
        }

        .blabel {
            font-weight: bold;
            margin-bottom: 10px;
            display: inline-block;
        }

        .pull-left {
            margin: 0px;
        }

        .pull-right {
            margin: 0px;
            text-align: right;
        }

        .nomagin p {
            margin: 0px !important;
        }

        td {
            padding: 5px;
            font-size: 18px;
            vertical-align: top;
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

    <div class="title" style="">
    <h2>COLLECTIONS REPORT - {{$date}}</h2>
    </div>

    <div class="clearfix">
        <div class="pull-left">
            <p><label class="blabel">Property:</label>
                <span class="value"><b>{{$property->name}}</b></span>
                <div style="clear:both;"></div>            
            </p>
        </div>
    </div>


<table style="width:100%;border:none">
<tr>
<td style="width:50%;border:none">
    
    <div class="clearfix">
        <div class="pull-left">    
            <h3 style="margin-bottom: 10px;"><u>Occupancy</u></h3>

                <label class="blabel">Total Units:</label>
                <span class="value"><b>{{number_format($totalunits)}}</b></span>
                <div style="clear:both;"></div>  
                 
                <label class="blabel">Occupied:</label>
                <span class="value"><b>{{number_format($totaloccupied)}}</b></span>
                <div style="clear:both;"></div>  
                 
                <label class="blabel">Vacant:</label>
                <span class="value"><b>{{number_format($totalvacant)}}</b></span>
                <div style="clear:both;"></div>  

        
        </div>
    </div>

</td>    



<td style="border:none">

    <div class="pull-right">
        <h3 style="margin-bottom: 10px;"><u>Summary</u></h3>

        <label class="blabel">Total Amount Due:</label>
            <span class="value"><b>{{$currency->code}} {{ number_format($totAmntDue, 2) }}</b></span>
            <div style="clear:both;"></div>  
            
            <label class="blabel">Total Paid Amount:</label>
            <span class="value"><b>{{$currency->code}} {{ number_format($totAmntPaid, 2) }}</b></span>
            <div style="clear:both;"></div>      

            <label class="blabel">Total Un-Paid:</label>
            <span class="value"><b>{{$currency->code}} {{ number_format($totAmntUnpaid, 2) }}</b></span>
            <div style="clear:both;"></div>      

    
    </div>

</td></tr>



    </table>
    <div class="margin-bellow">

        @include('reports.collections_print_table', ['schedules' => $schedules])
    </div>

@endsection
