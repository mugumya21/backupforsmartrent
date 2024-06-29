@if(!empty($search->tenant_unit_id))
<div class="col-md-6">
  @if (isset($request) && $request->submit !== 'PRINT')
  Total Debit:  <span class="totalsfont"> {{number_format($ledgers->sum('debit')) }}</span>

  &nbsp; &nbsp; &nbsp;  Total Credit:  <span class="totalsfont"> {{number_format($ledgers->sum('credit')) }}</span>

  &nbsp; &nbsp; &nbsp;  Outstanding Balance:  <span class="totalsfont"> {{number_format($ledgers->sum('debit') - $ledgers->sum('credit')) }}</span>
@endif
  </div>
    <table class="table table-hover" id="ledgers_table'" style="width:100%">
      <thead class="bg-200 text-900">
        <tr>
         
          <th style="width: 15%;">Date</th>
          <th style="width: 20%;">
            Item </th>
            <th style="width: 25%;">Description </th>
            <th style="width: 20%;">Debit  </th>

            <th style="width: 20%;">Credit  </th>

          {{-- <th class="sort" data-sort="name" style="    width: 20%; font-size: 14px !important;">Balance  </th> --}}

        </tr>

      </thead>
      <tbody class="list">

        @php
        $sortedLedgers = $ledgers->sortByDesc(function($ledger) {
            return strtotime($ledger->shortDate());
        });
    @endphp
    
    @foreach ($sortedLedgers as $key => $ledger)
        <tr>
            <td>{{$ledger->shortDate()}}</td>
            <td>{{$ledger->item}}</td>
            <td>{{$ledger->description}}</td>
            <td class="right">{{$ledger->debitDisp()}}</td>
            <td class="right">{{$ledger->creditDisp()}}</td>
            {{-- <td>{{$ledger->balanceDisp()}}</td> --}}
        </tr>
        {{-- @php $totalamount += $property->total @endphp --}}
    @endforeach

      </tbody>

    </table>

    @endif


