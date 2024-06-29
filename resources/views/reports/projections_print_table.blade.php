
    
    <table class="table table-striped table-bordered fs--1 mb-0" id="example" style="width:100%">
        <thead class="bg-200 text-900">
          <tr>
            <th class="sort" data-sort="name">Date </th>
            <th class="sort" data-sort="name">Unit </th>
            <th class="sort" data-sort="name">Tenant </th>
            <th class="sort" data-sort="name">Period </th>
            <th class="sort" data-sort="name">Amount </th>
           
    
          
         
          </tr>
        </thead>
        <tbody class="list">
          @php $totalbalance = 0 @endphp
          @php $totalpaid = 0 @endphp
          @php $totalamount = 0 @endphp
  
          @foreach ($schedules as $key =>  $schedule)
          <tr>
          <td>{{$schedule->from_date}}</td>
          <td>{{$schedule->tenantunit->unit->name}}</td>
          <td>{{$schedule->tenantunit->tenant->clientname()}}</td>
          <td>{{$schedule->shortFromDate()}} - {{$schedule->toDateProjection()}} </td>
          <td>{{$schedule->expectedamountDisp()}}</td>
          </tr>
          @php $totalbalance += $schedule->reportbalance($currency->id) @endphp
          @php $totalpaid += $schedule->reportpaidamount($currency->id) @endphp
          @php $totalamount += $schedule->expectedamount() @endphp
          @endforeach
  
        </tbody>
    
        <tfoot>
            <tr>
              <td style="text-align:right" class="bigfont" colspan="4">TOTAL</td>
              <td class="boldtotal"><b>{{number_format($totalamount) }}</b></td>
            </tr>
          </tfoot>
    
      </table>
    
     
    