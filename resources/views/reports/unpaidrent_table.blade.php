
<div class="col-md-6">
Total: <span class="totalsfont" id="grandtotal"></span>
</div>

<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Property </th>
        <th class="sort" data-sort="name">Tenant </th>
        <th class="sort" data-sort="name">Unit </th>
        <th class="sort" data-sort="name">Period </th>
        <th class="sort" data-sort="name">Amount </th>
        <th class="sort" data-sort="name">Paid </th>
        <th class="sort" data-sort="name">Balance </th>
       

      
     
      </tr>
    </thead>
    <tbody class="list">
        @php $totalbalance = 0 @endphp
        @php $totalpaid = 0 @endphp
        @php $totalamount = 0 @endphp
        @foreach ($schedules as $key =>  $schedule)
      <tr>
       <td>{{$schedule->tenantunit->property->name}}</td>
       <td>{{$schedule->tenantunit->tenant->clientname()}}</td>
       <td>{{$schedule->tenantunit->unit->name}}</td>
       <td>
        {{$schedule->shortFromDate()}}  - {{$schedule->shortToDate()}}
      </td>

      <td><span class="curr">{{$currency->code}}</span> {{$schedule->reportamountDisp($currency->id)}}</td>
      <td><span class="curr">{{$currency->code}}</span> {{$schedule->reportpaidamountDisp($currency->id)}} </td>
      <td><span class="curr">{{$currency->code}}</span> {{$schedule->reportbalanceDisp($currency->id)}} </td>

      </tr>
      @php $totalbalance += $schedule->reportbalance($currency->id) @endphp
      @php $totalpaid += $schedule->reportpaidamount($currency->id) @endphp
      @php $totalamount += $schedule->reportamount($currency->id) @endphp
      @endforeach

      <input type="text" class="hidden"  id="totalclass" value="{{number_format($totalbalance, 2) }}">
    </tbody>

    <tfoot>
        <tr>
            <td style="text-align:right" class="bigfont" colspan="4">TOTAL</td>
            <td class="boldtotal"><b>{{number_format($totalamount) }}</b></td>
            <td class="boldtotal"><b>{{number_format($totalpaid) }}</b></td>
            <td class="boldtotal"><b>{{number_format($totalbalance) }}</b></td>
          </tr>
    </tfoot>

  </table>

 
