  <table class="table table-striped table-bordered fs--1 mb-0" id="payschedule_tbl" style="width:100%">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">From</th>
        <th class="sort" data-sort="name">To</th>
        <th class="sort" data-sort="name">Unit</th>
        <th class="sort" data-sort="name">Tenant</th>
        <th class="sort" data-sort="name">Period</th>
        <th class="sort" data-sort="name">Amount</th>
        <th class="sort" data-sort="name">Paid</th>
        <th class="sort" data-sort="name">Balance</th>

     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($paymentschedules as $paymentschedule)
      <tr>
      
        <td>{{$paymentschedule->fromDate()}}</td>
        <td>{{$paymentschedule->toDate()}}</td>
        <td>{{$paymentschedule->unit->number}}</td>
        <td>{{$paymentschedule->client->clientname()}}</td>
        <td>{{$paymentschedule->period->name}}</td>
        <td>{{$paymentschedule->amountDisp()}}</td>
        <td>{{$paymentschedule->paidamountDisp()}}</td>
        <td>{{$paymentschedule->balanceDisp()}}</td>
        
      </tr>
      @endforeach
    </tbody>
  </table>

  <script>
    main.init();
    $('#payschedule_tbl').DataTable({
      "scrollX": true,
      'responsive': true,
      "autoWidth": false
    });
    </script>