<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">

<style>
      .choices .choices__list--dropdown .choices__item--selectable {
        font-size: 13px !important;
    }
    .choices {
    margin-bottom: 0px;
}
    </style>

<select name="schedule_id" class="form-select js-choice" multiple="multiple" id="schedule_id" required=""  size="1" name="organizerMultiple" data-options='{"removeItemButton":true,"placeholder":true}'>
    <option value="">Tenant Schedule</option>
@foreach ($paymentschedules as $paymentschedule)
<option value="{{$paymentschedule->id}}">TS ({{$paymentschedule->shortFromDate()}}) to ({{$paymentschedule->shortToDate()}}) Bal: {{$paymentschedule->balanceDisp()}}</option>
@endforeach


</select>

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>