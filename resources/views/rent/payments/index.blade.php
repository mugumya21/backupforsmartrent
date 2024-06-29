 <table class="table table-striped table-bordered fs--1 mb-0" id="payment_tbl" style="width:100%">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name" style="width:5%">Date</th>
        <th class="sort" data-sort="name">Tenant/Unit Name</th>
        <th class="sort" data-sort="name">Period</th>
        <th class="sort" data-sort="name">Amount Due</th>
        <th class="sort" data-sort="name">Paid</th>
        <th class="sort" data-sort="name">Balance</th>


      </tr>
    </thead>
    <tbody class="list">
        @foreach ($payments as $payment)
      <tr>
        <td> <a href="{{route('rent.payments.show',$payment)}}"> {{$payment->date()}}</a>  </td>
        <td>{{$payment->tenantunit->tenant->clientname()}} - {{$payment->tenantunit->unit->name}}</td>

        <td>@foreach($payment->items as $item)

            ({{$item->schedule->shortFromDate()}} - {{$item->schedule->shortToDate()}}) @if( !$loop->last)
            ,
        @endif @endforeach</td>

        <td><span class="curr">{{ $payment->tenantunit->currency->code }}</span> {{$payment->amountdueDisp()}}</td>
        <td><span class="curr">{{ $payment->tenantunit->currency->code }}</span> {{$payment->amountpaidDisp()}}</td>
        <td><span class="curr">{{ $payment->tenantunit->currency->code }}</span> {{$payment->balanceDisp()}}</td>

      </tr>
      @endforeach
    </tbody>
  </table>
  <script>
    main.init();
    $('#payment_tbl').DataTable({
      ordering: false
    });
  </script>
