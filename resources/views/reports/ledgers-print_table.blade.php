@if(!empty($search->tenant_unit_id))
<div class="col-md-6">
  Total: <span class="totalsfont" id="grandtotal"></span>
  </div>

  <table class="table table-striped table-bordered fs--1 mb-0" id="ledgers_table'">
      <thead class="bg-200 text-900">
        <tr>
          <th class="sort" data-sort="name" style="    width: 15%; font-size: 14px !important;">Date</th>
          <th class="sort" data-sort="name" style="    width: 15%; font-size: 14px !important;">Date</th>
          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">
            Item </th>
          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Description </th>
          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Debit  </th>

          <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Credit  </th>

          {{-- <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Balance  </th> --}}

        </tr>

      </thead>
      <tbody class="list">

        {{-- @php $totalamount = 0 @endphp --}}
      @foreach ($ledgers as $key =>  $ledger)
        <tr>
            <td>{{$ledger->date}}</td>
        <td>{{$ledger->shortDate()}}</td>
        <td>{{$ledger->item}}</td>
        <td>{{$ledger->description}}</td>
        <td>{{$ledger->debitDisp()}}</td>
        <td>{{$ledger->creditDisp()}}</td>
        {{-- <td>{{$ledger->balanceDisp()}}</td> --}}
      </tr>
        {{-- @php $totalamount += $property->total @endphp --}}
        @endforeach

      </tbody>

    </table>

    @endif


