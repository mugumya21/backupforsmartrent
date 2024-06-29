 <table class="table table-striped table-bordered fs--1 mb-0" id="expense_tbl" style="width:100%">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name" style="width:5%">Date</th>
        <th class="sort" data-sort="name">Unit</th>
        <th class="sort" data-sort="name">Category</th>
        <th class="sort" data-sort="name">Description</th>
        <th class="sort" data-sort="name">Amount</th>
        <th class="sort" data-sort="name">Done By</th>
        <th class="sort" data-sort="name">Status</th>

     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($expenses as $expense)
      <tr>
        <td> <a href="{{route('rent.expenses.show',$expense)}}"> {{$expense->dateDisp()}}</a>  </td>
        <td>@if(!empty($expense->unit)){{$expense->unit->name}}@endif</td>
        <td>{{$expense->category->name}}</td>
        <td>{{$expense->description}}</td>
        <td><span class="curr">{{ $expense->currency->code }}</span> {{$expense->amountDisp()}}</td>
        <td>{{$expense->createdBy->employee->full_name()}}</td> 
        <td>{!! $expense->expenseStatusDisp() !!}</td> 
      </tr>
      @endforeach
    </tbody>

<tfoot>

  <tr>
    <td colspan="6" style="text-align: right"><b>TOTAL</b></td>
<td class="boldtotal">{{$property->totalexpensesDisp()}}</td>
  </tr>

</tfoot>



  </table>
  <script>
    main.init();
    $('#expense_tbl').DataTable({
      ordering: false
    });
  </script>