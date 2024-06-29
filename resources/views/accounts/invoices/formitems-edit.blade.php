
@if(count($schedules) >0 )
<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name" style="width:30%;">Schedules</th>
        <th class="sort" data-sort="name">Description</th>
        <th class="sort" data-sort="name">Amount</th>
        <th class="sort" data-sort="name" style="width:15%;">Tax</th>
        <th class="sort" data-sort="name">Total amount</th>
      </tr>
    </thead>
    <tbody class="list">

      <tr>
        <td style="vertical-align: middle">
            
            <select name="schedule_ids[]" class="form-select js-choice choices" multiple="multiple" required id="schedule_id" size="1" data-trigger data-options='{"removeItemButton":true,"placeholder":true}'>
                <option value="">Select a schedule ...</option>

                @foreach($schedules as $schedule) 

                <option value="{{$schedule->id}}" selected >{{$schedule->shortFromDate()}} - {{$schedule->shortToDate()}} - {{$schedule->balanceDisp()}}  </option>  @endforeach

              </select>
             </td>


        <td style="vertical-align: middle">  {{ html()->textarea('description')->placeholder('Address')->class('form-control form-control-sm')->value($invoice->description)->placeholder('Description')->rows('3') }}</td>

        <td style="vertical-align: middle">   {{ html()->text('amount')->placeholder('Total Amount')->value(number_format($schedules->sum('balance'), 0))->class('form-control form-control-sm')->isReadonly()->id('amount_total') }}</td>

        <td style="vertical-align: middle">{{ html()->select('tax_id')->options($taxes->pluck('name','id'))->value($tax_id)->required()->class('form-select form-select-sm js-choice')->id('tax_id') }}</td>

        <td style="vertical-align: middle"> {{ html()->text('')->placeholder('Total Amount')->value(number_format($schedules->sum('balance'), 0))->class('form-control form-control-sm')->isReadonly()->id('amount_tax_total') }}</td>
        
      </tr>
 
    </tbody>
  </table>

  @else 

  <div class="alert alert-icon bg-transparent text-danger alert-danger alert-dismissible fade show" role="alert">
    <i style="font-size:15px;" class=" fas fa-times-circle"></i>
    <strong>Oops!</strong> No schedules found, please select another Unit.
</div>

{{ html()->hidden('')->value(count($schedules))->class('form-control form-control-sm')->id('buttontriger') }}

@endif
  
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js')}}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>

<script>
$('#schedule_id').on('change', function () {
var ids = $('#schedule_id').val(); 
var taxid = $("#tax_id :selected").val();

$.ajax({
type:'get',
url:'{{ route('accounts.computeinvoiceamount') }}',
data:{'ids':ids,'taxid':taxid},
success:function(data){
$('#amount_total').attr("value", data.amount);
$('#amount_tax_total').attr("value", data.taxamount);
},
error:function(){
}
});

});

$('#tax_id').on('change', function () {
var ids = $('#schedule_id').val(); 
var taxid = $("#tax_id :selected").val();

$.ajax({
type:'get',
url:'{{ route('accounts.computeinvoiceamount') }}',
data:{'ids':ids,'taxid':taxid},
success:function(data){
$('#amount_total').attr("value", data.amount);
$('#amount_tax_total').attr("value", data.taxamount);
},
error:function(){
}
});

});



$(document).ready(function() {
var resultsvalue =  $('#buttontriger').val(); 
if(resultsvalue == 0){
    $('.buttontriger').hide();
} else {
    $('.buttontriger').show();
}

});

</script>
