<meta charset="utf-8">
<title>{{ config('app.name', '') }} - @yield('title')</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
     .clearfix::after{
        content: "";
        clear: both;
        display: table;
    }
    .row {
        margin-right: -15px;
        margin-left: -15px;
    }

    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    dl {
        margin-top: 0;
        margin-bottom: 20px;
    }

    .dl-horizontal dt {
        float: left;
        width: 160px;
        overflow: hidden;
        clear: left;
        text-align: right;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-weight: bold;
    }

    .dl-horizontal dd {
        margin-left: 180px;
    }

    .center-block {
        display: block;
        margin-right: auto;
        margin-left: auto;
    }
    .pull-right {
        float: right !important;
    }
    .pull-left {
        float: left !important;
    }
    .hide {
        display: none !important;
    }
    .show {
        display: block !important;
    }
    .invisible {
        visibility: hidden;
    }
    .text-hide {
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }
    .hidden {
        display: none !important;
    }

    table thead th{
       background:black; 
       font-size: 16px;
    }

    table tr td{
       font-size: 15px;
    }

</style>

@yield('head-css')

