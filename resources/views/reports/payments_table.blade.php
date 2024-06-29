
<div class="col-md-6">
Total: <span class="totalsfont" id="grandtotal"></span>
</div>

<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Date </th>
        <th class="sort" data-sort="name">Property </th>
        <th class="sort" data-sort="name">Tenant </th>
        <th class="sort" data-sort="name">Unit </th>
        <th class="sort" data-sort="name">Period </th>
        <th class="sort" data-sort="name">Amount Paid </th>
  
      </tr>
    </thead>
    <tbody class="list">
    @php $total = 0 @endphp
        @foreach ($payments as $key =>  $payment)
      <tr>
       <td>{{$payment->date()}}</td>
       <td>{{$payment->property->name}}</td>
       <td>{{$payment->tenantunit->tenant->clientname()}}</td>
       <td>{{$payment->tenantunit->unit->name}}</td>
       <td>@foreach($payment->items as $item)
      
        {{$item->schedule->shortFromDate()}}  - {{$item->schedule->shortToDate()}}
      
      @endforeach</td>
      <td>{{ number_format($payment->reportamountpaid($currency->id), 2) }}</td>


      </tr>
    
      @php $total += $payment->reportamountpaid($currency->id) @endphp
      @endforeach

      <input type="text" class="hidden"  id="totalclass" value="{{number_format($total, 2) }}">
    </tbody>

    <tfoot>
      <tr>
        <td style="text-align:right" class="bigfont" colspan="5">TOTAL</td>
        <td class="boldtotal"><b>{{number_format($total, 2) }}</b></td>
      </tr>
    </tfoot>

  </table>

 
