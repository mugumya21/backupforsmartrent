@extends('layouts.modal-app')
@section('size')
 modal-lg mt-6
@endsection
@section('modal-content')

 <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

<div class="modal-body p-0">
        <div class="bg-light rounded-top-lg py-2 ps-3 pe-6">
          <h4 class="mb-1" id="staticBackdropLabel">Payment Schedule</h4>
        
        </div>
<div class="p-3">

  <table class="table table-striped table-bordered fs--1 mb-0" id="payschedule_tbl">
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


</div>
</div>

      @endsection
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>

<script>
main.init();
$('#payschedule_tbl').DataTable({
  scrollCollapse: true,
    scrollY: '250px'
});
</script>
