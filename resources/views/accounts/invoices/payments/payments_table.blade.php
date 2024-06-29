
<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
     
        <th class="sort" data-sort="name">Date</th>
        <th class="sort" data-sort="name">Invoice Number</th>
        <th class="sort" data-sort="name">Property</th>
        <th class="sort" data-sort="name">Payment Mode</th>
        <th class="sort" data-sort="name">Unit</th>
        <th class="sort" data-sort="name">Account</th>
        <th class="sort" data-sort="name">Description</th>
        <th class="sort" data-sort="name">Amount</th>
        <th class="sort" data-sort="name">Balance</th>
        
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($payments as $payment)
      <tr>

      <td>{{$payment->date()}}</td>
      <td>
        <a href="{{route('accounts.invoices.invoicepayments-create')}}" class="" aria-selected="true">{{$payment->InvoiceNumberDisp()}}</a>
      </td>
      <td>{{$payment->property->name}}</td>
      <td>{{$payment->paymentmode->name}}</td>
      <td>{{$payment->unit->name}}</td>
      <td>{{$payment->account->name}}</td>
      <td>{{$payment->description}}</td>      
      <td>{{$payment->amountDisp()}}</td>
      <td>{{$payment->balanceDisp()}}</td>
        
      </tr>
      @endforeach
    </tbody>
  </table>
