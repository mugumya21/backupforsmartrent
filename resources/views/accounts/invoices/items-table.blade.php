<table class="table table-hover full-width" style="width:100%" id="items_table">
  <thead class="light">
    <tr class="bg-primary text-white dark__bg-1000">
      <th class="border-0">Description</th>
      <th class="border-0">Period</th>
      <th class="border-0">Amount</th>
      <th class="border-0 text-center">Tax</th>
      <th class="border-0 text-center">Total amount</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td> RENT</td>
      <td class="align-middle">
        @foreach($invoice->items as $item)
        {{$item->schedule->fromDate()}}
        @endforeach
      </td>
      <td style="text-align:right">{{$invoice->amountDisp()}}</td>
     
      <td style="text-align:right">{{$invoice->totalTaxDisp()}}</td>
      <td style="text-align:right">{{$invoice->totalDisp()}}</td>
      

    </tr>


  </tbody>
</table>