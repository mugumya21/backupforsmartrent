 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="sche-tbl">
        <thead class="bg-200 text-900">
          <tr>
            <th class="sort" data-sort="name" style="width:30%">Period</th>
            <th class="sort" data-sort="name">Amount</th>
            <th class="sort" data-sort="name">Paid</th>
            <th class="sort" data-sort="name">Bal</th>
            <th class="sort" data-sort="name">Payment Terms</th>
            <th class="sort" data-sort="name">Expected Amount</th>
                  
         
          </tr>
        </thead>
        <tbody class="list">
            @foreach ($tenantunit->schedules as $schedule)
          <tr>
            <td>{{$schedule->shortFromDate()}} - {{$schedule->shortToDate()}}</td>
            <td>{{$schedule->tenantunit->discountamountDisp()}}</td>
            <td>{{$schedule->paidamountDisp()}}</td>
            <td>{{$schedule->balanceDisp()}}</td>
            <td>{{$schedule->tenantunit->terms}}</td>
            <td>{{$schedule->expectedamountDisp()}}</td>
        
          </tr>
          @endforeach
        </tbody>
      </table>
    