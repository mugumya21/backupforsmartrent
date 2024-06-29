@if(!empty($months))
<div class="col-md-6">
  Total: <span class="totalsfont" id="grandtotal"></span>
  </div>
  
  <table class="table table-striped table-bordered fs--1 mb-0" id="">
      <thead class="bg-200 text-900">
        <table style="width: 100%;">
        <tr>
          <th class="sort" data-sort="name" style="    width: 15%; font-size: 14px !important;">Unit</th>
          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Tenant </th>
          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Period </th>
          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Amount </th>
        </tr>
        </table>
      </thead>
      <tbody class="list">
    
        {{-- @php $totalamount = 0 @endphp --}}

      @foreach ($monthsarray as $key =>  $month)
        <tr>
        <td style="padding: 0px;" >
          
          <table style="width: 100%" class="table table-striped table-bordered fs--1 mb-0 fixed">
            <tr><td colspan="5" style="    background: #efefef;"> <span class="monthdisplay">{{$month->name}}</span> &nbsp;&nbsp;&nbsp;<span><b>TOTAL: <font style="color:red"> {{number_format($month->schedules->sum('payment_terms_amount')) }}</b></b></span></td></tr>
            @if(!empty($month->schedules->count() >0))
            @foreach($month->schedules as $schedule)
            <tr>
              <td style="border-left: 0px;     width: 15%;">{{$schedule->tenantunit->unit->name}}</td>
              <td style="    width: 20%;">{{$schedule->tenantunit->tenant->clientname()}}</td>
              <td style="    width: 20%;">{{$schedule->shortFromDate()}} - {{$schedule->toDateProjection()}} </td>
              <td style="    width: 20%; border-right: 0px;">{{$schedule->expectedamountDisp()}}</td>
            </tr>
            @endforeach

            @else 

            <tr>
              <td style="border-left: 0px;    width: 15%;"> &nbsp;</td>
              <td style="    width: 20%;">&nbsp;</td>
              <td style="    width: 20%;"></td>
              <td style="border-right: 0px; width: 20%;">0</td>
            </tr>

            @endif


          </table>
        </td>

      </tr>
   
        {{-- @php $totalamount += $property->total @endphp --}}
        @endforeach

      </tbody>
  
    </table>

    @endif
  
   
  