 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="sche-tbl">
        <thead class="bg-200 text-900">
          <tr>

            <th class="sort" data-sort="name">Period</th>
            <th class="sort" data-sort="name">Paid Amount</th>
            <th class="sort" data-sort="name">Balance</th>
                  
         
          </tr>
        </thead>
        <tbody class="list">
            @foreach ($payment->items as $item)
          <tr>
            <td>{{$item->schedule->shortFromDate()}} - {{$item->schedule->shortToDate()}}</td>
            <td><span class="curr">{{ $item->payment->tenantunit->currency->code }}</span> {{$item->paidamountDisp()}}</td>
            <td><span class="curr">{{$item->payment->tenantunit->currency->code }}</span> {{$item->balanceDisp()}}</td>
          
        
          </tr>
          @endforeach
        </tbody>
      </table>
    