  <table class="table table-striped table-bordered fs--1 mb-0" id="example" style="width:100%">
      <thead class="bg-200 text-900">
        <tr>
          <th class="sort" data-sort="name">Unit </th>
          <th class="sort" data-sort="name">Tenant </th>
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
         <td>{{$schedule->tenantunit->unit->name}}</td>
         <td>{{$schedule->tenantunit->tenant->clientname()}}</td>
         <td style="text-align:left">{{$schedule->shortFromDate()}}-{{$schedule->shortToDate()}}</td>
         <td style="text-align:right">{{$schedule->reportamountDisp($currency->id)}}</td>
         <td style="text-align:right">{{$schedule->reportpaidamountDisp($currency->id)}} </td>
         <td style="text-align:right">{{$schedule->reportbalanceDisp($currency->id)}} </td>
  
        </tr>
      
        @php $totalbalance += $schedule->reportbalance($currency->id) @endphp
        @php $totalpaid += $schedule->reportpaidamount($currency->id) @endphp
        @php $totalamount += $schedule->reportamount($currency->id) @endphp
        
        @endforeach

@if(!empty($vacantunits))
        @foreach ($vacantunits as  $vacant_schedule)
        <tr>
         <td>{{$vacant_schedule->name}}</td>
         <td>Vacant</td>
         <td><center>-</center></td>
         <td style="text-align:right">0</td>
         <td style="text-align:right">0 </td>
         <td style="text-align:right">0</td>
        </tr>
        @endforeach
@endif
  

      </tbody>
  
      <tfoot>
          <tr>
            <td style="text-align:right" class="bigfont" colspan="3">TOTAL</td>
            <td style="text-align:right"><b>{{number_format($totalamount) }}</b></td>
            <td style="text-align:right"><b>{{number_format($totalpaid) }}</b></td>
            <td style="text-align:right"><b>{{number_format($totalbalance) }}</b></td>
          </tr>
        </tfoot>
  
    </table>
  
   
  