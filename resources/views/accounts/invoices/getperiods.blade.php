
<select name="payment_schedule_id[]" class="form-select js-choice choices" multiple="multiple" required id="schedule_id" size="1" data-trigger data-options='{"removeItemButton":true,"placeholder":true}'>
    @foreach($items as $item) 
    <option value="{{$item->schedule->id}}" selected>{{$item->schedule->shortFromDate()}} - {{$item->schedule->shortToDate()}} - {{$item->schedule->balanceDisp()}}  </option>  @endforeach
</select>

  <script src="{{ asset('vendors/prism/prism.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="../../../vendors/choices/choices.min.js"></script>
  <script src="{{ asset('assets/js/cleave.js') }}"></script>