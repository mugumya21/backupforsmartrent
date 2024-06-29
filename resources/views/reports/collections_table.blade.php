
<div class="col-md-6">
  Total: <span class="totalsfont" id="grandtotal"></span>
  </div>
  
  <table class="table table-striped table-bordered fs--1 mb-0" id="example">
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
        <td>{{$schedule->shortFromDate()}} - {{$schedule->shortToDate()}}</td>
        <td>{{$schedule->reportamountDisp($currency->id)}}</td>
        <td>{{$schedule->reportpaidamountDisp($currency->id)}} </td>
        <td>{{$schedule->reportbalanceDisp($currency->id)}} </td>
  
        </tr>
      
        @php $totalbalance += $schedule->reportbalance($currency->id) @endphp
        @php $totalpaid += $schedule->reportpaidamount($currency->id) @endphp
        @php $totalamount += $schedule->reportamount($currency->id) @endphp
        @endforeach


        @foreach ($vacantunits as  $vacant_schedule)
        <tr>
         <td>{{$vacant_schedule->name}}</td>
         <td>Vacant</td>
         <td><center>-</center></td>
         <td>0</td>
         <td>0 </td>
         <td>0</td>
        </tr>
        @endforeach

      </tbody>
  
      <tfoot>
          <tr>
            <td style="text-align:right" class="bigfont" colspan="3">TOTAL</td>
            <td class="boldtotal"><b>{{number_format($totalamount) }}</b></td>
            <td class="boldtotal"><b>{{number_format($totalpaid) }}</b></td>
            <td class="boldtotal"><b>{{number_format($totalbalance) }}</b></td>
          </tr>
        </tfoot>
  
    </table>
  
   
  