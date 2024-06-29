
<table class="table table-striped table-bordered fs--1 mb-0" id="payments_tbl">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Date</th>
        <th class="sort" data-sort="name">Amount Paid</th>
        <th class="sort" data-sort="name">Balance</th>
        <th class="sort" data-sort="name"></th>

      
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($invoice->payments as $payment)
      <tr>

        <td>{{$payment->date()}}</td>
        <td>{{$payment->amountDisp()}}</td>
        <td>{{$payment->balanceDisp()}}</td>

        
      </tr>
      @endforeach
    </tbody>
  </table>
