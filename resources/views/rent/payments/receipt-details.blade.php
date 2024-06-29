 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="sche-tbl" style="width:100%">
            <thead class="bg-200 text-900">
              <tr>
    
                <th class="sort" data-sort="name">Item</th>
                <th class="sort" data-sort="name">Period</th>
                <th class="sort" data-sort="name">Paid</th>
                <th class="sort" data-sort="name">Balance</th>
                      
              </tr>
            </thead>
            <tbody class="list">
             
              @foreach($payment->items as $item)

                <tr>

            <td>RENT</td>
                    <td>
                        ({{$item->schedule->shortFromDate()}} - {{$item->schedule->shortToDate()}}) 
                    </td>
                    <td>{{$item->paidamountDisp()}}</td>
                    <td>{{$item->balanceDisp()}}</td>
             
                  </tr>
                  @endforeach
         
            </tbody>
          </table>
        